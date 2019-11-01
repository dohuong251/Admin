<?php
$languages = ["Afrikaans", "Albanian", "Arabic", "Armenian", "Azerbaijani", "Basque", "Belarusian", "Bulgarian", "Catalan", "Chinese", "Simplified", "Chinese", "Traditional", "Czech", "Danish", "English", "Estonian", "Filipino", "Finnish", "French", "Galician", "Georgian", "German", "Greek", "Haitian", "Creole", "Hebrew", "Hindi", "Hungarian", "Icelandic", "Indonesian", "Irish", "Italian", "Japanese", "Korean", "Latvian", "Lithuanian", "Macedonian", "Malay", "Maltese", "Norwegian", "Persian", "Polish", "Portuguese", "Romanian", "Russian", "Serbian", "Slovak", "Slovenian", "Spanish", "Swahili", "Swedish", "Thai", "Turkish", "Ukrainian", "Vietnamese", "Welsh", "Yiddish"];
if (!isset($language)) $language = "English";
?>
@foreach($languages as $lang)
    <option value="{{$lang}}" {{strcasecmp($lang,$language)==0?'selected':''}}>{{$lang}}</option>
@endforeach
