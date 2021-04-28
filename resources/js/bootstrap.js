window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.html2canvas = new require("html2canvas")

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.tokenize = (code) => {
    var results = [];
    var tokenRegExp = /\s*([A-Za-z]+|[0-9]+|\S)\s*/g;

    var m;
    while ((m = tokenRegExp.exec(code)) !== null)
        results.push(m[1]);
    return results;
}

window.isNumber = (token) => {
    return token !== undefined && token.match(/^[0-9]+$/) !== null;
}

window.isName = (token) => {
    return token !== undefined && token.match(/^[A-Za-z]+$/) !== null;
}

window.parse = (code) => {

    var tokens = tokenize(code);

    var position = 0;


    function peek() {
        return tokens[position];
    }


    function consume(token) {
        position++;
    }

    function parsePrimaryExpr() {
        var t = peek();

        if (isNumber(t)) {
            consume(t);
            return {
                type: "number",
                value: t
            };
        } else if (isName(t)) {
            consume(t);
            return {
                type: "name",
                id: t
            };
        } else if (t === "(") {
            consume(t);
            var expr = parseExpr();
            if (peek() !== ")")
                throw new SyntaxError("expected )");
            consume(")");
            return expr;
        } else {
            throw new SyntaxError("expected a number, a variable, or parentheses");
        }
    }

    function parseMulExpr() {
        var expr = parsePrimaryExpr();
        var t = peek();
        while (t === "*" || t === "/") {
            consume(t);
            var rhs = parsePrimaryExpr();
            expr = {
                type: t,
                left: expr,
                right: rhs
            };
            t = peek();
        }
        return expr;
    }

    function parseExpr() {
        var expr = parseMulExpr();
        var t = peek();
        while (t === "+" || t === "-") {
            consume(t);
            var rhs = parseMulExpr();
            expr = {
                type: t,
                left: expr,
                right: rhs
            };
            t = peek();
        }
        return expr;
    }

    var result = parseExpr();
    if (position !== tokens.length) {
        console.log(tokens)
        throw new SyntaxError("unexpected '" + peek() + "' at position " + position);
    }
    return result;
}

window.calculate = (code) => {
    var variables = Object.create(null);
    variables.e = Math.E;
    variables.pi = Math.PI;

    function evaluate(obj) {
        switch (obj.type) {
            case "number":
                return parseInt(obj.value);
            case "name":
                return variables[obj.id] || 0;
            case "+":
                return evaluate(obj.left) + evaluate(obj.right);
            case "-":
                return evaluate(obj.left) - evaluate(obj.right);
            case "*":
                return evaluate(obj.left) * evaluate(obj.right);
            case "/":
                return evaluate(obj.left) / evaluate(obj.right);
        }
    }
    return evaluate(parse(code));
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });