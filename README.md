# PHP Task - List Files From Google Drive

### Click [Here](http://yii.ibra.info) to Show the Demo

## To run the application

- clone this repo
- `cd Google-Drive-Yii/`
- `composer install`
- `php init`
- Select Development Environment
> Note: The file backend/credentials.json shold be writable

Action used to render the form:

Controller: `backend\controllers\SiteController` Action: `indexAction`

The core code is inside component

`backend\components\GoogleDriveClient`