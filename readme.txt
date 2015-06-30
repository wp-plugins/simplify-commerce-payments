=== Simplify Commerce Payments ===
Contributors: Tips and Tricks HQ, wptipsntricks
Donate link: http://www.tipsandtricks-hq.com/
Tags: simplify, payment, payments, button, shortcode, digital goods, payment gateway, instant payment, commerce, digital downloads, download, downloads, e-commerce, e-store, ecommerce, eshop, donation, mastercard  
Requires at least: 4.2
Tested up to: 4.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Accept payments from your WordPress site via Simplify Commerce by MasterCard payment gateway.

== Description ==
 
This plugin allows you to accept credit card payments via Simplify Commerce by MasterCard. It has a simple shortcode that lets you place a buy button on your site and get paid for the item instantly.

= Features =

* Sell virtual, tangible or downloadable products online using Simplify Commerce.
* Sell files, digital goods or downloads.
* Sell music, video, ebook, PDF or any other digital media files.
* Quick installation and setup.
* The ultimate e-commerce plugin to create Simplify Commerce buy buttons.
* Create a payment buttons on the fly using a shortcode and embed it anywhere on your website.
* Ability to add multiple payment buttons to a post/page.
* Allow a user to automatically download the file once the purchase is complete.
* View payments/orders received via Simplify Commerce from your WordPress admin dashboard.

The setup is quick and easy. Once you have installed the plugin, all you need to do is enter your Simplify Commerce API credentials in the plugin settings (Settings -> Accept Simplify Payments) and your website will be ready to accept credit card payments.

You can run it in test mode before going live.

= Shortcode Attributes =

In order to create a buy button insert the following shortcode into a post/page.

`[accept_simplify_payment name="My Product" price="19.99" button_text="Buy Now"]`

It supports the following attributes in the shortcode -

    name:
    (string) (required) Name of the product
    Possible Values: 'Test Product', 'My Ebook', 'My Video' etc.

    price:
    (number) (required) Price of the product or item
    Possible Values: '9.99', '15.49', '20' etc.

    quantity:
    (number) (optional) Number of products to be charged. By default it's set to 1.
    Possible Values: '1', '3', '5' etc.

    currency:
    (string) (optional) Currency of the price specified.
    Possible Values: 'USD', 'GBP' etc
    Default: The one specified in Settings area.
    
    url:
    (URL) (optional) URL of the downloadable file (if applicable)
    Possible Values: http&#58;//example.com/my-downloads/test-product.zip

    button_text:
    (string) (optional) Label of the payment button
    Possible Values: 'Buy Now', 'Pay Now' etc

For detailed instructions please check the [WordPress Simplify Commerce Plugin](https://www.tipsandtricks-hq.com/ecommerce/wordpress-simplify-plugin-accept-payments-using-simplify-commerce) documentation page.

== Installation ==

= Using The WordPress Dashboard =

1. Navigate to "Plugins->Add New" from your dashboard
2. Search for 'simplify commerce payments'
3. Click 'Install Now'
4. Activate the plugin

= Uploading via WordPress Dashboard =

1. Navigate to the "Add New" in the plugins dashboard
2. Navigate to the "Upload" area
3. Select `simplify-commerce-payments.zip` from your computer
4. Click "Install Now"
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `simplify-commerce-payments.zip`
2. Extract the `simplify-commerce-payments` directory on your computer
3. Upload the `simplify-commerce-payments` directory to the `/wp-content/plugins/` directory
4. Activate it from the Plugins dashboard

== Frequently Asked Questions ==

= Can I have multiple payment buttons on a single page? =

Yes, you can have any number of buttons on a single page.

= Can I use it in a WordPress Widgets? =

Yes, you can.

= Can I specify quantity of the item? =

Yes, please use "quantity" attribute.

= Can I change the button label? =

Yes, please use "button_text" attribute

= Can It be tested before going live? =

Yes, please visit Settings > Accept Simplify Payments screen for options.


== Screenshots ==

1. Simplify Commerce Plugin Settings
2. Simplify Commerce Payment Page
3. Simplify Commerce Plugin Orders Menu

== Upgrade Notice ==
None

== Changelog ==

= 1.0 =
* First Release