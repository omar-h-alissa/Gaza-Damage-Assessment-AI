const mix = require('laravel-mix');
const glob = require('glob');
const path = require('path');
const ReplaceInFileWebpackPlugin = require('replace-in-file-webpack-plugin');
const WebpackRTLPlugin = require('webpack-rtl-plugin');
const del = require('del');
const fs = require('fs');

const args = getParameters();
const dir = 'resources/_keenthemes/src';

mix.options({
    cssNano: { discardComments: false }
});

// تنظيف المجلدات قبل البدء
del.sync(['public/assets/*']);

// 1. بناء ملفات الـ CSS والـ JS الأساسية
mix.sass('resources/mix/plugins.scss', `public/assets/plugins/global/plugins.bundle.css`)
    .options({processCssUrls: false})
    .scripts(require('./resources/mix/plugins.js'), `public/assets/plugins/global/plugins.bundle.js`);

mix.sass(`${dir}/sass/style.scss`, `public/assets/css/style.bundle.css`, {sassOptions: {includePaths: ['node_modules']}})
    .options({processCssUrls: false})
    .scripts(require(`./resources/mix/scripts.js`), `public/assets/js/scripts.bundle.js`);

// 2. معالجة الخطوط والأيقونات (التعامل مع الخطأ المذكور)
const fontsSource = `${dir}/plugins/global/fonts`;
const fontsDest = `public/assets/plugins/global/fonts`;

if (fs.existsSync(fontsSource)) {
    mix.copyDirectory(fontsSource, fontsDest);
} else {
    // إذا كان المجلد غير موجود، نحاول النسخ من مجلد النود موديولز أو المسار البديل في ماترونيك
    console.warn('Warning: Global fonts directory not found in src, trying alternative paths...');
    // أحياناً ماترونيك تضع الخطوط في هذا المسار
    const altFontsSource = `node_modules/bootstrap-icons/font/fonts`;
    if (fs.existsSync(altFontsSource)) {
        mix.copyDirectory(altFontsSource, `${fontsDest}/bootstrap-icons`);
    }
}

// نسخ أيقونات KeenIcons (التي سألت عنها)
// نبحث عنها في كل مجلد السورس لضمان العثور عليها
const keenIconsSource = `${dir}/plugins/custom/keenicons`;
if (fs.existsSync(keenIconsSource)) {
    mix.copyDirectory(keenIconsSource, `${fontsDest}/keenicons`);
}

// 3. نسخ الوسائط (Media)
mix.copyDirectory(`${dir}/media`, `public/assets/media`);

// 4. إعدادات الـ Webpack لتصحيح الروابط في ملفات الـ RTL
let plugins = [
    new ReplaceInFileWebpackPlugin([
        {
            dir: path.resolve(`public/assets/plugins/global`),
            test: /\.css$/,
            rules: [
                {
                    // تصحيح مسار KeenIcons (Duotone) ليعمل في العربي
                    search: /url\(.*?(keenicons-.*?)\.(woff2?|eot|ttf|svg).*?\)/g,
                    replace: 'url(./fonts/keenicons/$1.$2)',
                },
                {
                    search: /url\((\.\.\/)?webfonts\/(fa-.*?)"?\)/g,
                    replace: 'url(./fonts/@fortawesome/$2)',
                },
                {
                    search: /url\(.*?(bootstrap-icons\..*?)"?\)/g,
                    replace: 'url(./fonts/bootstrap-icons/$1)',
                },
            ],
        },
    ]),
];

if (args.indexOf('rtl') !== -1) {
    plugins.push(new WebpackRTLPlugin({
        filename: '[name].rtl.css',
        minify: false,
    }));
}

mix.webpackConfig({
    plugins: plugins,
    stats: {
        children: true,
    },
});

function getParameters() {
    var possibleArgs = ['rtl'];
    for (var i = 0; i <= 13; i++) { possibleArgs.push('demo' + i); }
    var args = [];
    possibleArgs.forEach(function (key) {
        if (process.env['npm_config_' + key]) { args.push(key); }
    });
    return args;
}
