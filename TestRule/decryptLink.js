const express = require('express');
const router = express.Router();
let requestPromise = require('request-promise').defaults({jar: true});

router.post('/', async (req, res) => {
    if (req.body.url && req.body.rules) {
        let results = await getLink(req.body.url, JSON.parse(req.body.rules)).catch(e => {
            res.json({
                result: 0,
                stepResults: [{
                    step: "exception",
                    action: "",
                    result: e.toString(),
                }]
            });
        });
        if (results && results.result) {
            res.json({
                result: 1,
                url: results.url,
                stepResults: results.stepResults
            });
        } else {
            res.json({
                result: 0,
                stepResults: results.stepResults
            })
        }
    } else {
        res.json({
            result: 0,
            reason: "Thiếu Tham Số",
        });
    }
});

module.exports = router;

// let debugIds = [8];

let debugIds = [];

function getLink(link, rules) {
    return new Promise(async (resolve, reject) => {
        let stepResults = [];
        let goto;
        let Link = link;
        let tempResult;
        try {
            for (let ite = 0; ite < rules.Rules.length; ite++) {
                let rule = rules.Rules[ite];
                if (Link.indexOf(rule.Match) !== -1) {
                    console.log(rule.Name);
                    for (let j = 0; j < rule.Stages.length; j++) {
                        let stage = rule.Stages[j];
                        if (debugIds.indexOf(stage.Id) !== -1) debugger;
                        if (goto && stage.Id != goto) continue;
                        goto = undefined;
                        console.log(stage.Id, stage.Action);
                        switch (stage.Action) {
                            case "GOTO":
                                if (stage.Stage.match(/^\$\w+$/)) {
                                    stage.Stage = eval(stage.Stage.match(/\w+/)[0]);
                                }
                                goto = stage.Stage;

                                stepResults.push({
                                    step: stage.Id,
                                    action: stage.Action,
                                    result: stage.Stage,
                                });
                                break;

                            case "CONCAT":
                                // duyệt mảng thay các chuỗi bắt đầu bằng giá trị biến
                                stage.Targets.forEach((target, index) => {
                                    if (target.match(/^\$\w+$/)) {
                                        stage.Targets[index] = eval(target.match(/\w+/)[0]);
                                    }
                                });

                                eval(`${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(stage.Targets.join(""))}`);

                                stepResults.push({
                                    step: stage.Id,
                                    action: stage.Action,
                                    result: `${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(stage.Targets.join(""))}`,
                                });
                                break;

                            case "EVAL":
                                if (stage.String.match(/^\$\w+$/)) {
                                    stage.String = eval(stage.String.match(/\w+/)[0]);
                                } else stage.String = eval(stage.String);
                                tempResult = eval(stage.String);
                                eval(`${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(tempResult)}`);

                                stepResults.push({
                                    step: stage.Id,
                                    action: stage.Action,
                                    result: `${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(tempResult)}`,
                                });
                                break;

                            case "REPLACE":
                                if (stage.In.match(/^\$\w+$/)) {
                                    stage.In = eval(stage.In.match(/\w+/)[0]);
                                }
                                if (stage.From.match(/^\$\w+$/)) {
                                    stage.From = eval(stage.From.match(/\w+/)[0]);
                                }
                                if (stage.To.match(/^\$\w+$/)) {
                                    stage.To = eval(stage.To.match(/\w+/)[0]);
                                }

                                let replaceRegex = new RegExp(`${escapeRegExp((stage.From))}`, "gm");
                                // let replaceRegex = new RegExp(`${((stage.From))}`, "gm");
                                tempResult = stage.In.replace(replaceRegex, stage.To);
                                eval(`${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(tempResult)}`);

                                stepResults.push({
                                    step: stage.Id,
                                    action: stage.Action,
                                    result: `${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(tempResult)}`,
                                });
                                break;

                            case "GET":
                                if (stage.Link.match(/^\$\w+$/)) {
                                    stage.Link = eval(stage.Link.match(/\w+/)[0]);
                                }

                                if (stage.Headers && stage.Headers.match(/^\$\w+$/)) {
                                    stage.Headers = eval(stage.Headers.match(/\w+/)[0]);
                                }

                                let options = {
                                    uri: stage.Link,
                                    headers: {},
                                    resolveWithFullResponse: true
                                };
                                let headers = stage.Headers;
                                if (headers) {
                                    headers = headers.split("::");
                                    headers.forEach((headerValue, index) => {
                                        if (index % 2 === 0) options.headers[headerValue] = "";
                                        else options.headers[headers[index - 1]] = headerValue;
                                    });
                                }

                                let requestSucess = false;
                                await requestPromise(options).then(function (htmlString) {
                                    console.log(htmlString.body);
                                    eval(`${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(htmlString.body)}`);
                                    requestSucess = true;
                                    stepResults.push({
                                        step: stage.Id,
                                        action: stage.Action,
                                        result: `${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(htmlString.body)}`,
                                    });
                                })
                                    .catch(function (err) {
                                        if (err.statusCode === 503 || err.statusCode === 302) {
                                            eval(`${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(err.error)}`);
                                            requestSucess = true;
                                            stepResults.push({
                                                step: stage.Id,
                                                action: stage.Action,
                                                result: `${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(err.error)}`,
                                            });
                                        } else {
                                            requestSucess = false;
                                            console.error(err);
                                            stepResults.push({
                                                step: stage.Id,
                                                action: stage.Action,
                                                result: err.toString(),
                                            });
                                        }
                                    });
                                if (!requestSucess) return resolve({
                                    result: false,
                                    stepResults: stepResults,
                                });
                                break;

                            case "POST":
                                if (stage.Link.match(/^\$\w+$/)) {
                                    stage.Link = eval(stage.Link.match(/\w+/)[0]);
                                }

                                if (stage.Headers && stage.Headers.match(/^\$\w+$/)) {
                                    stage.Headers = eval(stage.Headers.match(/\w+/)[0]);
                                }

                                if (stage.Params.match(/^\$\w+$/)) {
                                    stage.Params = eval(stage.Params.match(/\w+/)[0]);
                                }
                                stage.Params = stage.Params.split("::");

                                let postOptions = {
                                    method: 'POST',
                                    uri: stage.Link,
                                    headers: {},
                                    body: stage.Params.map((value, index) => {
                                        if (index % 2 === 0) return `${value}=`;
                                        else return `${value}&`;
                                    }).join("")
                                };

                                let postHeaders = stage.Headers;
                                if (postHeaders) {
                                    postHeaders = postHeaders.split("::");
                                    postHeaders.forEach((headerValue, index) => {
                                        if (index % 2 === 0) postOptions.headers[headerValue] = "";
                                        else postOptions.headers[postHeaders[index - 1]] = headerValue;
                                    });
                                }

                                let postRequestSucess = false;
                                await requestPromise(postOptions).then(function (htmlString) {
                                    console.log(htmlString);
                                    eval(`${stage.Result.match(/\w+/)[0]}=${JSON.stringify(htmlString)}`);
                                    postRequestSucess = true;
                                    stepResults.push({
                                        step: stage.Id,
                                        action: stage.Action,
                                        result: `${stage.Result.match(/\w+/)[0]}=${JSON.stringify(htmlString)}`,
                                    });
                                })
                                    .catch(function (err) {
                                        postRequestSucess = false;
                                        console.error(err);
                                        stepResults.push({
                                            step: stage.Id,
                                            action: stage.Action,
                                            result: err.toString(),
                                        });
                                    });
                                if (!postRequestSucess) return resolve({
                                    result: false,
                                    stepResults: stepResults,
                                });

                                break;

                            case "MATCH":
                                let matchString = stage.Target;
                                if (stage.Target.match(/^\$\w+$/)) {
                                    matchString = eval(stage.Target.match(/\w+/)[0]);
                                }

                                if (stage.String.match(/^\$\w+$/)) {
                                    stage.String = eval(stage.String.match(/\w+/g)[0]);
                                }

                                if (stage.Default && stage.Default.match(/^\$\w+$/)) {
                                    stage.Default = eval(stage.Default.match(/\w+/g)[0]);
                                }

                                if (stage.MatchId.match(/^\$\w+$/)) {
                                    stage.MatchId = eval(stage.MatchId.match(/\w+/g)[0]);
                                }

                                if (stage.GroupId.match(/^\$\w+$/)) {
                                    stage.GroupId = eval(stage.GroupId.match(/\w+/g)[0]);
                                }

                                tempResult = stage.Default || "";
                                let matchRegex = new RegExp(`${stage.String}`, "g");
                                let matchId = 0, match;
                                while ((match = matchRegex.exec(matchString)) !== null) {
                                    if (matchId == stage.MatchId) {
                                        tempResult = match[stage.GroupId];
                                        break;
                                    }
                                    matchId++;
                                }

                                eval(`${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(tempResult)}`);

                                stepResults.push({
                                    step: stage.Id,
                                    action: stage.Action,
                                    result: `${stage.Result.match(/\w+/)[0]} = ${JSON.stringify(tempResult)}`,
                                });
                                break;
                            case "FINAL":
                                return resolve({
                                    result: true,
                                    url: eval(stage.Result.match(/\w+/)[0]),
                                    stepResults: stepResults
                                });
                        }
                    }
                }
            }
            return resolve({
                stepResults:[{
                    step: "exception",
                    action: "",
                    result: "Rule not match",
                }]
            });
        } catch (e) {
            console.error("Get link exeption: " + e);
            stepResults.unshift({
                step: "exception",
                action: "",
                result: e.toString(),
            });
            resolve({
                result: false,
                stepResults: stepResults,
            });
        }
    }).catch((e) => {
    })
}

function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}


module.exports = router;
