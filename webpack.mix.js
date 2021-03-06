const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

mix.js("resources/js/app.js", "public/js")
    .js(
        "resources/js/clients/payment_methods/authorize-stripe-card.js",
        "public/js/clients/payment_methods/authorize-stripe-card.js"
    )
    .js(
        "resources/js/clients/payment_methods/authorize-authorize-card.js",
        "public/js/clients/payment_methods/authorize-authorize-card.js"
    )
    .js(
        "resources/js/clients/payments/authorize-credit-card-payment.js",
        "public/js/clients/payments/authorize-credit-card-payment.js"
    )
    .js(
        "resources/js/clients/payment_methods/authorize-ach.js",
        "public/js/clients/payment_methods/authorize-ach.js"
    )
    .js(
        "resources/js/clients/invoices/action-selectors.js",
        "public/js/clients/invoices/action-selectors.js"
    )
    .js(
        "resources/js/clients/invoices/payment.js",
        "public/js/clients/invoices/payment.js"
    )
    .js(
        "resources/js/clients/payments/sofort.js",
        "public/js/clients/payments/sofort.js"
    )
    .js(
        "resources/js/clients/payments/alipay.js",
        "public/js/clients/payments/alipay.js"
    )
    .js(
        "resources/js/clients/payments/checkout.com.js",
        "public/js/clients/payments/checkout.com.js"
    )
    .js(
        "resources/js/clients/quotes/action-selectors.js",
        "public/js/clients/quotes/action-selectors.js"
    )
    .js(
        "resources/js/clients/quotes/approve.js",
        "public/js/clients/quotes/approve.js"
    )
    .js(
        "resources/js/clients/payments/process.js",
        "public/js/clients/payments/process.js"
    )
    .js(
        "resources/js/setup/setup.js", 
        "public/js/setup/setup.js"
    )
    .js(
        "node_modules/card-js/card-js.min.js",
        "public/js/clients/payments/card-js.min.js"
    )
    .js(
        "resources/js/clients/shared/pdf.js",
        "public/js/clients/shared/pdf.js"
    )
    .js(
        "resources/js/clients/shared/multiple-downloads.js",
        "public/js/clients/shared/multiple-downloads.js"
    );

mix.copyDirectory('node_modules/card-js/card-js.min.css', 'public/css/card-js.min.css');

mix.sass("resources/sass/app.scss", "public/css")
    .options({
        processCssUrls: false,
        postCss: [tailwindcss("./tailwind.config.js")]
    });
mix.version();
mix.disableNotifications();