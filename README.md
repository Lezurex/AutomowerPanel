# 🤖 AutomowerPanel

<img src="https://github.com/Lezurex/AutomowerPanel/blob/main/dashboard/assets/img/favicon.svg" height="50" alt="logo">

> The german README can be found [here](https://github.com/Lezurex/AutomowerPanel/blob/main/README_DE.md).

With this Website you can control your Husqvarna Automower via your PC. The general commands start, stop and park are supported. The official API from Husqvarna is used. Every user can log in with their Husqvarna account and get started right away.<br />
Due to the limitation of the API to a maximum of 10'000 calls per month, the status has to be updated manually in order to save this volume of requests.<br />
**DISCLAIMER**: This site was a trial project of a first year computer science apprentice. The correct function is not guaranteed! However, this project may be developed further.

## 🎮 Features
This control panel has all the functionality that the official Husqvarna API has to offer.
- Current status of the lawnmower can be viewed at any time
- Starting the mower according to schedule or temporary override
- Parking of the mower according to schedule, temporary override or until further notice
- Stopping the mower
- If there are several mowers in the account, you can select and control them individually
- Error messages (details can be folded in/out)
- Server-side spam protection (3 seconds cool down)

## 💾 Installation

In order to use the website itself, an additional file must be created in which the configuration is stored. To do this, create a file `config.php` file in `/php/` and insert the following code:
```PHP
<?php

function getAppKey() {
    return "APP_KEY"; // Enter your app key here
}

function getAppSecret() {
    return "APP_SECRET"; // Enter your app's secret here
}

function getActivityStrings() {
    return array(
        "UNKNOWN" => "Unknown",
        "NOT_APPLICABLE" => "Manual start required",
        "MOWING" => "Mowing",
        "GOING_HOME" => "Going home",
        "CHARGING" => "Charging",
        "LEAVING" => "Leaving station",
        "PARKED_IN_CS" => "Parked in station",
        "STOPPED_IN_GARDEN" => "Stopped in garden"
    );
}

function getStateStrings() {
    return array(
        "UNKNOWN" => "Unknown",
        "NOT_APPLICABLE" => "Manual start required",
        "PAUSED" => "Paused",
        "IN_OPERATION" => "In operation",
        "WAIT_UPDATING" => "Downloading updated",
        "WAIT_POWER_UP" => "Performs start tests",
        "RESTRICTED" => "Restricted",
        "OFF" => "Off",
        "STOPPED" => "Stopped - intervention necessary",
        "ERROR" => "Error",
        "FATAL_ERROR" => "Fatal Error",
        "ERROR_AT_POWER_UP" => Error at startup
    );
}

function getWeekdayStrings() {
    return array(
        "1" => "Monday",
        "2" => "Tuesday",
        "3" => "Wednesday",
        "4" => "Thursday",
        "5" => "Friday",
        "6" => "Saturday",
        "7" => "Sunday"
    );
}
```
A new Husqvarna application can be created at https://developer.husqvarnagroup.cloud/apps The **Authentication API** and **Automower Connect API** must be enabled.
In this file you can also change certain strings, for example for the different statuses.

## ♻ Used frameworks
### SB Admin
For the panel the [template of Start Bootstrap](https://startbootstrap.com/templates/sb-admin/) was used und modified.

### Bootstrap & jQuery
The website is using [Bootstrap](https://getbootstrap.com/) and [jQuery](https://jquery.com).

# ⚖️ License
This project is licensed under the GNU GPL v3 and may be used accordingly. Further information can be found [here](https://github.com/Lezurex/AutomowerPanel/blob/main/LICENSE).

The logo is from [Freepik](https://www.flaticon.com/de/autoren/freepik).
