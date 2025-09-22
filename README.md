# Plant Classification

- update UI
- generate Blank cell

## Dependencies
```
composer require intervention/image-laravel

```

## make a service class
php artisan make:class Services/GeminiService
php artisan make:class Services/ImageService

## Reference
https://data.addrun.org

## Development
```
php artisan make:model Plant -m
php artisan make:seeder PlantSeeder
php artisan db:seed --class=PlantSeeder

npm install dayjs

php artisan make:model Translation -m

php artisan make:controller Api/DictionaryController --api

php artisan make:controller Api/DeployController --api

```

## ngrok
ngrok config add-authtoken 1vDeEeToexwQtanEzEY7kzxwJJ3_7FJwn3e3b8yL8RDuJQ4Js
ngrok http http://localhost:8000

## GBIF: https://www.gbif.org

### Occurrences

- UI Example
https://www.gbif.org/occurrence/search

https://www.gbif.org/occurrence/search?country=TH&taxon_key=6&year=2023,2025

- occurrence: TH | inaturalist.org | Plantae | 2024
https://www.gbif.org/occurrence/search?country=TH&publishing_org=28eb1a3f-1c15-4a95-931a-4af90ecb574d&taxon_key=6&year=2024
GBIF.org (06 February 2025) GBIF Occurrence Download  https://doi.org/10.15468/dl.qqy5wr

GBIF.org (06 February 2025) GBIF Occurrence Download  https://doi.org/10.15468/dl.332y63

- API: occurrences
https://api.gbif.org/v1/occurrence/search
https://api.gbif.org/v1/occurrence/search?country=TH&kingdomKey=6&limit=10

http://localhost:8000/api/gbif/plants/occurrence?offset=100

https://api.gbif.org/v1/species/5383898


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
