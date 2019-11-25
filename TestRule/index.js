let bodyParser = require('body-parser');

const express = require('express');
const app = express();
const port = 3000;
const parseUrlRouter = require('./decryptLink');

app.use(bodyParser.urlencoded({
    extended: true,
    limit: '50mb',
}));

app.use(bodyParser.json({
    extended: true,
    limit: '50mb',
}));

app.listen(port, (err) => {
    if (err) throw err;
    console.log(`server is listening on ${port}`);
});

app.use('/parseUrl', parseUrlRouter);
