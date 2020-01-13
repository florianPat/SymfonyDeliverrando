/*
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

function importAll(r) {
    r.keys().forEach(r);
}

// any CSS you require will output into a single css file (app.css in this case)
try {
    const css = require.context('./css/', true, /\.scss$/);
    importAll(css);
} catch(error) {
    console.log(error);
}

const $ = require('jquery');

try {
    const js = require.context('./js/', true, /\.js$/);
    importAll(js);
} catch(error) {
    console.log(error);
}