# Rapid API for Drupal 8

![Drupal 8 logo](https://psv4.vk.me/c810222/u23905118/docs/65a4d1f65a06/Ra_Drupal_8.png?extra=ST3BW1TQ9GesYPhQWFf6CLwtHfGu4x-UnVLZik_l2gw71-VcKAzS6glC7qNfx-6sLQI9cRqnwnklb_PP27z6TSMigMtOzLStstiUZPBNaGbuVOZXqK8W5Q)

## Install

- Clone repo from GitHub: `git clone https://github.com/emerap/ra_drupal.git`
- Install composer dependencies: `composer install`
- [Drush](http://www.drush.org/en/master/install) install: `drush en ra_drupal ra_docs -y`

## Drupal console commands

- Generate plugin RaDatatype - `drupal generate:plugin:ra:datatype`
- Generate plugin RaDefinition - `drupal generate:plugin:ra:definition`
- Generate plugin RaFormat - `drupal generate:plugin:ra:format`

## Basic usage

```
// Method name
$method_name = 'ra.version';

// Method params
$params = ['field' => 'engine'];

// \Emerap\Ra\Core\Method instance
$method = RaConfig::instanceMethod($method_name, $params);

// Call api method
$result = RaConfig::instanceRa->call();

// Get method response
$response = $result->format();
```

## Links

- Rapid API core: [source](https://github.com/emerap/ra) | [packagist](https://packagist.org/packages/emerap/ra)
- Community page: [vk.com/rapid_api](https://vk.com/rapid_api)

Copyright &copy; 2016 [ [Pokhodyun Alexander](https://vk.com/karbunkul)]