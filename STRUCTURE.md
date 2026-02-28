# Store website – folder structure

```
app/
├── Http/Controllers/
│   ├── CategoryController.php   # index, show (category products)
│   ├── CheckoutController.php   # index (UI only)
│   ├── HomeController.php       # index
│   ├── OfferController.php      # index (scope: stock_units > 50)
│   └── ProductController.php    # index (paginated), show (route model binding)
├── Models/
│   ├── Category.php
│   ├── Product.php              # scopeOffers(), isInStock()
│   └── ProductUnit.php
routes/
└── web.php                      # REST-style named routes
resources/views/
├── components/
│   ├── footer.blade.php
│   └── navbar.blade.php
├── layouts/
│   └── app.blade.php
└── pages/
    ├── categories/
    │   ├── index.blade.php
    │   └── show.blade.php
    ├── checkout/
    │   └── index.blade.php
    ├── home.blade.php
    ├── offers/
    │   └── index.blade.php
    └── products/
        ├── index.blade.php
        └── show.blade.php
```

## Routes

| Method | URI | Name | Controller@method |
|--------|-----|------|-------------------|
| GET | / | home | HomeController@index |
| GET | /products | products.index | ProductController@index |
| GET | /products/{product} | products.show | ProductController@show |
| GET | /categories | categories.index | CategoryController@index |
| GET | /categories/{category} | categories.show | CategoryController@show |
| GET | /offers | offers.index | OfferController@index |
| GET | /checkout | checkout.index | CheckoutController@index |
