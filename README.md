# Theme for body-works

> Please commit to this repository when doing any changes on body-works website! Be kind for future developers 🙃

This is child theme for [body-works.pl](https://body-works.pl/). Send me pull requests or fork this repo if you want to do any changes.

This project uses:

* Grunt
* SCSS
* Non-transpiled JS (only terser involved)

Do changes in `src` directory and use:

* `grunt assets` to regenerate all assets.
* `grunt watch` to generate css in wach mode.

Also remember to bump theme version in:

* `src/scss/main.scss`
* `theme-config.php`

This way you'll bust cache!

## Development instructions

Install npm packages:

```
npm install
```

Run `Grunt` in watch mode to generate new assets on the fly:

```
grunt watch
```

Run `Grunt` in default mode to create responsive images:

```
grunt default
```

## Configuration

All PHP options to configure template can be found in the `theme-config.php` file.

### Translations

Use `Poedit` with domain `body_works`.

### Snippets etc.

To protect email addresses use:

```html
<span data-email-protection="true">contact[małpa]realhe.ro</span>
```

You can find templates for products in `docs` directory, by using **copy & paste** you'll speed up development!