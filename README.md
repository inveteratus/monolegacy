# Monolegacy

## Requirements

* php : 8.3
* node : 20.17
* composer : 2.7
* npm : 10.8
* docker 27.2

Note, these are not fixed in stone - you may have success with other versions/tools.

## Installation

```sh
git clone git@github.com:inveteratus/monolegacy.git
cd monolegacy
composer install
npm install
sail up -d
npm run dev
```

You can now access the site by naviagting to [localhost](http://localhost).
