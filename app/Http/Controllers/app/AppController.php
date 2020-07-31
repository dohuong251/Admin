<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppsRequest;
use App\Models\Apps\AppResources;
use App\Models\Apps\Apps;
use App\Models\Apps\AppVersion;
use App\Models\Apps\Category;
use App\Models\Apps\Connections;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use function foo\func;

class AppController extends Controller
{
    //
    public function index()
    {
        //return "hello";
        return view('apps.apps', [
            'apps' => Apps::join('app_version', function ($join) {
                $join->on('app_version.app_id', '=', 'app.app_id');
            })
                ->groupBy('app.app_id')
                ->orderBy('show', 'desc')
                ->orderBy('last_update', 'desc')
                ->get(),

        ]);
    }

    public function overview(Request $request){
        if($request->has('type_time')) $type_time = intval($request->get('type_time'));
        $app_id = 'com.ustv.v2';
        if($request->has('app_id')) $app_id = $request->get('app_id');
        $selected_version = "0";
        if($request->has('selected_version')) $selected_version = $request->get('selected_version');
        if($request->has('start_date') && $request->has('end_date')){
            $filter_days = $this->getBetweenDays($request->get('start_date'),$request->get('end_date'));
        }else $filter_days = $this->getLastDays(7);

        //return $filter_days;

        // truy vấn database
        $active_count = array();
        $new_user_count = array();
        $query = Connections::where('id_application',$app_id);
        if($selected_version == "0"){}
        else $query = $query->where('Version',$selected_version);

        foreach($filter_days as $day){
            $query_clone = clone $query;
            $query_clone = $query_clone->whereBetween('Time',[$day.' 00:00:00',$day.' 23:59:59']);
            //return $query->toSql();
            //$active_count[] = $query_clone->count();
            $active_count[] = 0;
            // new user
            //$new_user_count[] = $query_clone->where('NewUser',1)->count();
            $new_user_count[] = 0;
        }

        // top country
        $query = DB::connection('mysql_tool_connection')
                    ->table('connections')->select(DB::raw('count(*) as country_count,Country'))
                    ->where('id_application',$app_id)
                    ->whereBetween('Time',[$filter_days[0],$filter_days[count($filter_days)-1]])
                    ->groupBy('Country')
                    ->orderBy('country_count','desc')
                    ->limit(10);
        if($selected_version == "0"){}
        else $query = $query->where('Version',$selected_version);
        $top_countries = $query->get();
        $allCountryCount = $top_countries->sum('country_count');
        $countries_name = array();
        $countries_percent = array();
        foreach ($top_countries as $top_country){
            $countries_name[] = $top_country->Country;
            $countries_percent[] = intval($top_country->country_count/$allCountryCount * 100);
        }

        // top version
        $all_versions = $this->getVersions($app_id);
        return $all_versions;
        return view('apps.overview', ['app_id'=>$app_id,
                                            'selected_version'=>$selected_version,
                                            'versions'=>$all_versions,
                                            'countries_name'=>$countries_name,
                                            'countries_percent'=>$countries_percent,
                                            'filter_days'=>$filter_days,
                                            'new_user_count'=>$new_user_count,
                                            'active_count'=>$active_count,
                                            'start_date'=>$filter_days[0],
                                            'end_date'=>$filter_days[count($filter_days)-1]]);

    }

    public function getVersions($app_id){
        return DB::connection('mysql_tool_connection')
            ->table('connections')
            ->select('Version')
            ->where('id_application',$app_id)
            ->groupBy('Version')
            ->pluck('Version');
    }

    public function getBetweenDays($start_date,$end_date){
        $days = array();
        $endCarbon = Carbon::parse($end_date);
        while (true){
            $loopDay = $endCarbon->format('Y-m-d');;
            $days[] = $loopDay;
            $endCarbon->subDay();
            if($start_date == $loopDay) break;
        }
        return array_reverse($days);
    }

    public function getLastDays($count){
        $days = array();
        $cbToday = Carbon::now();
        for ($i=0;$i<$count;$i++){
            $days[] = $cbToday->format('Y-m-d');
            $cbToday->subDay();
        }
        return array_reverse($days);
    }

    public function show($appId)
    {
        $apps = AppVersion::with('platform')->select(["app_version_id", "icon_url", "version_name", "app_version_name", "platform_id"])
            ->where('app_id', $appId)
            ->orderBy('platform_id', 'asc')
            ->orderBy('last_update', 'desc')
            ->get();
        return view('apps.app_detail', [
            'apps' => $apps
        ]);
    }

    public function create()
    {
        return view('apps.app_create');
    }

    public function store(AppsRequest $request)
    {
        $request->validated();

        DB::connection('mysql_mdc_apps_connection')->beginTransaction();
        try {
            $newApp = new Apps();
            $newApp->app_name = $request->get('app_version_name');
            $newApp->category_id = $request->get('category_id');
            $newApp->save();
            $appVersion = new AppVersion($request->only(['platform_id', 'platform_id', 'icon_url', 'app_version_name', 'app_version_subname', 'package_name', 'version_name', 'size', 'ads_image', 'download_url', 'last_update', 'create_time', 'playstoreURL', 'appleUrl', 'amazoneUrl', 'portableUrl', 'requires', 'portuguese_requires', 'what_new', 'description', 'portuguese_what_new', 'portuguese_description']));
            $newApp->appVersions()->save($appVersion);
            if ($request->get('Video') != null) {
                $appVersion->appResources()->save(new AppResources([
                    'type' => 'Video',
                    'link' => $request->get('Video')
                ]));
            }

            if ($request->get('Image') != null) {
                $images = [];
                foreach ($request->get('Image') as $image) {
                    if ($image == null) continue;
                    array_push($images, ['type' => 'Image', 'link' => $image]);
                }
                $appVersion->appResources()->createMany($images);
            }
            DB::connection('mysql_mdc_apps_connection')->commit();
            return redirect(route('admin.apps.show', $newApp->app_id));
        } catch (Exception $exception) {
            DB::connection('mysql_mdc_apps_connection')->rollback();
            return back()->withInput();
        }
    }

    public function addVersion($appId, Request $request)
    {
        $platformId = $request->get('platform');
        return view('apps.app_version_create', [
            'app' => AppVersion::where(['app_id' => $appId, 'platform_id' => $platformId])->orderBy('last_update', 'desc')->take(1)->get()->first()
        ]);
    }

    public function storeVersion($appId, AppsRequest $request)
    {
        $request->validated();
        $platformId = $request->get('platform');
        return DB::connection('mysql_mdc_apps_connection')->transaction(function () use ($request, $platformId, $appId) {
            $app = Apps::find($appId);
            if ($app == null) {
                return back()->withInput()->withErrors(['warningMessage' => 'App Not Found']);
            }
            $appVersion = new AppVersion();
            $appVersion->fill($request->only(['platform_id', 'platform_id', 'icon_url', 'app_version_name', 'app_version_subname', 'package_name', 'version_name', 'size', 'ads_image', 'download_url', 'last_update', 'create_time', 'playstoreURL', 'appleUrl', 'amazoneUrl', 'portableUrl', 'requires', 'portuguese_requires', 'what_new', 'description', 'portuguese_what_new', 'portuguese_description']));
            $app->appVersions()->save($appVersion);

            if ($request->get('Video') != null) {
                $appVersion->appResources()->save(new AppResources([
                    'type' => 'Video',
                    'link' => $request->get('Video')
                ]));
            }

            if ($request->get('Image') != null) {
                $images = [];
                foreach ($request->get('Image') as $image) {
                    if ($image == null) continue;
                    array_push($images, ['type' => 'Image', 'link' => $image]);
                }
                $appVersion->appResources()->createMany($images);
            }
            return redirect(route('admin.apps.edit_version', ["version_id" => $appVersion->app_version_id]));
        });
    }

    public function editVersion(Request $request)
    {
        return view('apps.app_version_edit', [
            'app' => AppVersion::find($request->get('version_id'))
        ]);
    }

    public function update(AppsRequest $request)
    {
        $request->validated();

        return DB::connection('mysql_mdc_apps_connection')->transaction(function () use ($request) {
            $app = AppVersion::find($request->get('app_version_id'));
            if ($app == null) {
                return back()->withInput()->withErrors(['warningMessage' => 'App Not Found']);
            }
            $app->fill($request->only(['platform_id', 'platform_id', 'icon_url', 'app_version_name', 'app_version_subname', 'package_name', 'version_name', 'size', 'ads_image', 'download_url', 'last_update', 'create_time', 'playstoreURL', 'appleUrl', 'amazoneUrl', 'portableUrl', 'requires', 'portuguese_requires', 'what_new', 'description', 'portuguese_what_new', 'portuguese_description']));
            $app->save();
            $app->appResources()->delete();
            if ($request->get('Video') != null) {
                $app->appResources()->save(new AppResources([
                    'type' => 'Video',
                    'link' => $request->get('Video')
                ]));
            }

            if ($request->get('Image') != null) {
                $images = [];
                foreach ($request->get('Image') as $image) {
                    if ($image == null) continue;
                    array_push($images, ['type' => 'Image', 'link' => $image]);
                }
                $app->appResources()->createMany($images);
            }

            return back();
//            return back()->with(['version_id'=>$request->get('app_version_id')]);
        });
    }

    public function destroy($appVersionId)
    {
        AppVersion::destroy($appVersionId);
    }

    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
        return null;
    }

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
        return null;
    }
}
