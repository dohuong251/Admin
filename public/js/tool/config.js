$(document).ready(function () {

    $('#mainContent > div').addClass('px-0');

    $('input[name=configSearch]').keyup(function () {
        let searchVal = $(this).val().trim().toLowerCase();
        $('.config-name span').each(function () {
            // tìm chuỗi nhập vào trong thông tin contact (tên, email, facebookid), ẩn contact không khớp
            if ($(this).text().trim().toLowerCase().includes(searchVal)) {
                $(this).parent().removeClass('d-none').addClass('peers');
            } else {
                $(this).parent().addClass('d-none').removeClass('peers');
            }
        });
        $('.config-name').parent().scrollTop(0);
    });

    $('.config-name').click(function () {
        isAddApp = false;
        $(this).addClass('active').siblings('.config-name').removeClass('active');
        $('#config-name-input').addClass('d-none');
        $('#config-name').removeClass('d-none');
        loadConfig();
    }).first().click();

    $('body').on('click', '.submit-config', function () {
        let config = $('.config-content').find('.input-group').each(function () {
            $(this).find('.value').attr('name', $(this).find('.name').val());
        }).find('input, textarea').serializeArray();

        $('.json-config-group').each(function () {
            let jsonValue = {};
            $(this).find('.input-group').each(function () {
                jsonValue[`${$(this).find('.json-name').val()}`] = $(this).find('.json-value').val()
            });
            config.push({
                name: $(this).find('.data-json-prefix').val(),
                value: JSON.stringify(jsonValue),
            });
        });

        // config.forEach(function (v,i) {
        //     if (v.name === "message_web") {
        //         console.log(config, config[i]);
        //     }
        // });
        // return;

        if (isAddApp) {
            // them app config
            let appId = $('#config-name-input').val();
            if (!appId) {
                $('#config-name-input').siblings('input[type=submit]').click();
                return;
            }
            $.ajax({
                url: '',
                method: 'post',
                data: {
                    id: appId,
                    device: $('#device').val(),
                    config: config,
                },
                success: function (response) {
                    Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                    }).fire({
                        icon: 'success',
                        title: 'App Config Added'
                    });
                },
            });
        } else {
            // chinh sua app config
            $.ajax({
                url: '',
                method: 'put',
                data: {
                    id: $('.config-content input[name=appid]').val(),
                    device: $('.config-content input[name=device]').val(),
                    config: config,
                },
                success: function (response) {
                    Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                    }).fire({
                        icon: 'success',
                        title: 'Config Changed'
                    });
                },
            });
        }
    }).on('click', '.remove-config', function () {
        $(this).closest('.config-group').remove();
    }).on('click', '.add-config', function () {
        $('.config-container').append(configItemRender());
    }).on('click', '#add-app, #add-app-duplicate', function () {
        isAddApp = true;
        $('.config-name').removeClass('active');
        $('#config-name-input').removeClass('d-none');
        $('#config-name').addClass('d-none');
        if ($(this).attr('id') === "add-app") {
            // create new application -> remove current config html content
            // create new application from current config -> keep current config html content
            $('.config-container').empty();
        }
    }).on('click', '.mark-json', function () {
        let json = $(this).closest('.config-group').find('.value').val();
        try {
            json = JSON.parse(json.replace(/\\\\/g, "\\\\"));
        } catch (exception) {
            try {
                json = JSON.parse(repairJSON(json));
            } catch (e) {
                return Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).fire({
                    icon: 'error',
                    title: 'JSON value invalid'
                });
            }
        }
        let jsonPrefix = $(this).closest('.config-group').find('.name').val();
        for (let key in json) {
            if (typeof json[key] === "object") json[key] = JSON.stringify(json[key]);
        }
        $(this).closest('.config-group').replaceWith(jsonConfigRender({
            prefix: jsonPrefix,
            json: json
        }));
    }).on('click', '.add-json-config', function () {
        $(this).closest('.json-config-group').append(jsonConfigItemRender());
    }).on('click', '.preview-html', function () {
        let previewWindow = window.open("", "", "width=375,height=667");
        previewWindow.document.write($(this).closest('.config-group').find('.json-value').val())
    })
});

let loadConfigAjax,
    configContentRender = Handlebars.compile(document.getElementById("config-content").innerHTML),
    configItemRender = Handlebars.compile(document.getElementById("config-item").innerHTML),
    jsonConfigRender = Handlebars.compile(document.getElementById("json-config-content").innerHTML),
    jsonConfigItemRender = Handlebars.compile(document.getElementById("json-config-item").innerHTML),
    isAddApp = false;

Handlebars.registerPartial('configItem', document.getElementById("config-item").innerHTML);
Handlebars.registerPartial('jsonConfigItem', document.getElementById("json-config-item").innerHTML);
Handlebars.registerHelper('isJSONField', function (str, options) {
    if (str === "message_web" || str === "message") return options.fn(this);
    else return options.inverse(this);
});

/**
 * load config app bằng ajax
 * dữ liệu trả về:
 * {
 *     id: tên app
 *     data: mảng các trường trong config dưới dạng {"name":"ads","value":"2"}
 * }
 */
function loadConfig() {
    if (isAddApp) return;
    if (loadConfigAjax && loadConfigAjax.hasOwnProperty('abort')) loadConfigAjax.abort();
    // $('.config-content').empty();
    $('.config-content').html("");
    loadConfigAjax = $.ajax({
        url: '',
        data: {
            id_application: $('.config-name.active span').text(),
            device: $('#device').val()
        },
        success: function (data) {
            if (data && data.hasOwnProperty('id') && data.hasOwnProperty('data')) {
                $('#config-name').text(data.id);
                $('.config-content').html(configContentRender(data));
                $('textarea.value').each(function () {
                    $(this).height(75)
                })
            }
        },
    });
}

function repairJSON(n) {
    var i = [],
        o = 0,
        e = n.match(/^\s*(\/\*(.|[\r\n])*?\*\/)?\s*[\da-zA-Z_$]+\s*\(([\s\S]*)\)\s*;?\s*$/);
    e && (n = e[3]);
    var t, r = {
        "\b": "\\b",
        "\f": "\\f",
        "\n": "\\n",
        "\r": "\\r",
        "\t": "\\t"
    };

    function s() {
        return n.charAt(o)
    }

    function a() {
        return n.charAt(o + 1)
    }

    function l(e) {
        return " " === e || "\n" === e || "\r" === e || "\t" === e
    }

    function c() {
        for (var e = i.length - 1; 0 <= e;) {
            var t = i[e];
            if (!l(t)) return t;
            e--
        }
        return ""
    }

    function h() {
        for (var e = o + 1; e < n.length && l(n[e]);) e++;
        return n[e]
    }

    function d() {
        for (o += 2; o < n.length && ("*" !== s() || "/" !== a());) o++;
        o += 2
    }

    function u() {
        for (o += 2; o < n.length && "\n" !== s();) o++
    }

    function p(e) {
        var t = "";
        t += '"', o++;
        for (var i = s(); o < n.length && i !== e;) '"' === i && "\\" !== n.charAt(o - 1) ? t += '\\"' : r.hasOwnProperty(i) ? t += r[i] : ("\\" === i && (o++, "'" !== (i = s()) && (t += "\\")), t += i), o++, i = s();
        return i === e && (t += '"', o++), t
    }

    function f() {
        for (var e = "", t = s(), i = /[a-zA-Z_$\d]/; i.test(t);) e += t, o++, t = s();
        return -1 === ["null", "true", "false"].indexOf(e) ? '"' + e + '"' : e
    }

    function g() {
        for (var e, t = s(), i = "";
             /[a-zA-Z_$]/.test(t);) i += t, o++, t = s();
        if (0 < i.length && "(" === t) {
            if (o++, '"' === (t = s())) e = p(t), t = s();
            else
                for (e = "";
                     ")" !== t && "" !== t;) e += t, o++, t = s();
            return ")" === t ? (o++, e) : i + "(" + e + t
        }
        return i
    }

    for (; o < n.length;) {
        var m = s();
        "/" === m && "*" === a() ? d() : "/" === m && "/" === a() ? u() : " " === (t = m) || " " <= t && t <= " " || " " === t || " " === t || "　" === t ? (i.push(" "), o++) : "'" === m ? i.push(p(m)) : '"' === m ? i.push(p('"')) : "`" === m ? i.push(p("´")) : "‘" === m ? i.push(p("’")) : "“" === m ? i.push(p("”")) : "," === m && -1 !== ["]", "}"].indexOf(h()) ? o++ : /[a-zA-Z_$]/.test(m) && -1 !== ["{", ","].indexOf(c()) ? i.push(f()) : /[a-zA-Z_$]/.test(m) ? i.push(g()) : (i.push(m), o++)
    }
    return i.join("")
}
