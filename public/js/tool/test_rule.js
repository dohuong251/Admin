$(document).ready(function () {
    //select2 select page rule
    let defaultConfig = {};
    try {
        defaultConfig = JSON.parse($('#rule').val());
    } catch (e) {
        console.warn(e);
    }


    let selectedRuleIndex = null;
    $('#select-page-rule').select2().on('select2:select', function (e) {
        if (defaultConfig.Rules) {
            for (let [index, pageRule] of defaultConfig.Rules.entries()) {
                if ($(e.target).val() === "0") {
                    $('#page-rule').html(ruleRender());
                    selectedRuleIndex = -1;
                    dragula([$('.stage-container')[0]]);
                }
                if (pageRule.Match === $(e.target).val()) {
                    $('#rule').val(JSON.stringify(pageRule, null, 2));
                    $('#page-rule').html(ruleRender(pageRule));
                    selectedRuleIndex = index;
                    dragula([$('.stage-container')[0]]);
                    return;
                }
            }
        }
    }).trigger('select2:select');

    //copy json content
    new ClipboardJS('#json-copy').on('success', function (e) {
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        }).fire({
            icon: 'success',
            title: 'Copied!'
        });
    }).on('error', function (e) {
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
        }).fire({
            icon: 'error',
            title: 'Failed!'
        });
    });

    let updateRuleRequest = null;
    $('body').on('click', '#json-validate, #json-repair, #json-beautify', function () {
        let jsonString = $('#rule').val();
        if (jsonString) {
            switch ($(this).attr('id')) {
                case "json-validate":
                    let validate = jsonHelper.validate(jsonString);
                    if (validate.valid) {
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        }).fire({
                            icon: 'success',
                            title: 'JSON valid'
                        });
                    } else {
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                        }).fire({
                            icon: 'error',
                            title: validate.message,
                        });
                    }
                    break;
                case "json-repair":
                    $("#rule").val(jsonHelper.repair(jsonString));
                    break;
                case "json-beautify":
                    if (jsonHelper.validate(jsonString).valid) {
                        $("#rule").val(jsonHelper.beautify(jsonString));
                    } else {
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                        }).fire({
                            icon: 'error',
                            title: 'JSON invalid',
                        });
                    }
                    break;
                default:
                    break;
            }
        }
    }).tooltip({
        selector: '[data-toggle="tooltip"]'
    }).on('click', '.collapse-step-result', function () {
        $(this).toggleClass('fa-rotate-90')
        // .siblings('div:not(.step-result-text)').toggleClass('d-none')
            .siblings('.step-result-text').toggleClass('ellipsis');
    }).on('click', '#update-rule', function () {
        if (!$('#match')[0].reportValidity() || !$('#name')[0].reportValidity()) return;
        let addRule = false;
        let newRule = getRule();
        if (selectedRuleIndex != null) {
            if (selectedRuleIndex === -1) {
                defaultConfig.Rules.push(newRule);
                addRule = true;
            } else {
                defaultConfig.Rules[selectedRuleIndex] = newRule;
            }
        }
        updateRuleRequest = $.ajax({
            url: $(this).attr('data-url'),
            type: "PUT",
            data: {
                rule: JSON.stringify(defaultConfig)
            },
            beforeSend: function () {
                if (updateRuleRequest != null) {
                    updateRuleRequest.abort();
                }
            },
            success: (data) => {
                if (data != 0) {
                    Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    }).fire({
                        icon: 'success',
                        title: 'Rule Update!'
                    });
                    if(addRule){
                        var newOption = new Option(newRule.Match, newRule.Match, false, false);
                        $('#select-page-rule').append(newOption).trigger('change');
                    }
                } else {
                    Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    }).fire({
                        icon: 'error',
                        title: 'Rule Update Failed Or Not Changed!'
                    });
                }
            }
        });
    });

    let ruleFormRequest;
    $('#rule-form').submit(function (e) {
        e.preventDefault();
        let rules = getRule();

        if (ruleFormRequest) ruleFormRequest.abort();
        ruleFormRequest = $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: [{
                name: "url",
                value: $('#url').val(),
            }, {
                name: "rules",
                value: JSON.stringify(rules),
            }],
            success: (data) => {
                data = JSON.parse(data);
                $('#result').html(testRuleResultTemplate(data));

                $("html, body").animate({scrollTop: $("#result").offset().top - $('.header-container').height() - 10}, 1000);

                new ClipboardJS('#result-link').on('success', function (e) {
                    $(e.trigger).tooltip('hide')
                        .attr('data-original-title', "Đã sao chép!")
                        .tooltip('show');
                }).on('error', function (e) {
                    $(e.trigger).tooltip('hide')
                        .attr('data-original-title', "Sao chép lỗi!")
                        .tooltip('show');
                });
                $('#result-link').mouseleave(function () {
                    $(this).attr('data-original-title', "Nhấp để sao chép");
                });
            },
        });
    }).on('click', '.add-step', function () {
        // $(this).before(stageJsonItemRender());
        $(this).closest('.step').after(stageJsonItemRender());
    }).on('click', '.remove-step', function () {
        let stage = $(this).closest('.rule-stage');
        $(this).closest('.step').remove();
        if (stage.find('input, textarea').length === 0) {
            stage.remove();
        }
    }).on('click', '.add-stage', function () {
        $('.stage-container').append(stageItemRender({
            stageJSON: {
                Id: "",
                Action: "",
                Result: "",
            }
        }));

        $("html, body").animate({scrollTop: $(".stage-container").prop("scrollHeight")}, 1000);
    });
});

Handlebars.registerPartial('stageItemTemplate', document.getElementById("stage-item-template").innerHTML);
Handlebars.registerPartial('stageJSONItemTemplate', document.getElementById("stage-json-item-template").innerHTML);
Handlebars.registerHelper('is_step_exception', function (str, options) {
    if (str === "exception") {
        return options.fn(this);
    } else {
        return options.inverse(this);
    }
});m
Handlebars.registerHelper('stringify_json_step_value', function (value) {
    if (typeof value === "object") return JSON.stringify(value);
    else return value;
});
Handlebars.registerHelper('is_json_step_value', function (value, options) {
    if (typeof value === "object") return options.fn(this);
    else return options.inverse(this);
});

let testRuleResultTemplate = Handlebars.compile(document.getElementById("result-template").innerHTML),
    ruleRender = Handlebars.compile(document.getElementById("rule-template").innerHTML),
    stageItemRender = Handlebars.compile(document.getElementById("stage-item-template").innerHTML),
    stageJsonItemRender = Handlebars.compile(document.getElementById("stage-json-item-template").innerHTML);

function getRule() {
    $('.rule-stage').find('.input-group').each(function () {
        $(this).find('.value').attr('name', $(this).find('.name').val());
    });

    let rules = [];
    $('.rule-stage').each(function () {
        let step = {};
        $(this).find('input, textarea').each(function () {
            if ($(this).attr('name')) {
                if ($(this).attr('data-json-value') || $(this).attr('name') === "Targets") step[`${$(this).attr('name')}`] = JSON.parse($(this).val());
                else step[`${$(this).attr('name')}`] = $(this).val();
            }
        });
        rules.push(step);
    });
    return {
        Match: $('#match').val(),
        Name: $('#name').val(),
        Stages: rules,
    }
}

let jsonHelper = {
    beautify: function (jsonString) {
        return JSON.stringify(jsonlint.parse(jsonString), null, 2);
    },
    validate: function (jsonString) {
        try {
            let result = jsonlint.parse(jsonString);
            if (result) {
                return {
                    valid: true
                }
            }
        } catch (e) {
            return {
                valid: false,
                message: e.toString()
            }
        }

    },
    repair: function (n) {
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
};
