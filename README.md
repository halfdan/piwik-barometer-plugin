# Piwik Barometer Plugin

This is a plugin for the Open Source Web Analytics platform Piwik. If enabled, it will add a new Widget that you can add to your dashboard.

The Widget will show a Visitor Barometer that auto-refreshs every 5 seconds. It shows the number of visitors in a N minute period compared to the maximum number of visitors in any N minute period of the last 30 days.

The idea for this plugin came from [@muesli](http://github.com/muesli) who suggested it on #piwik in IRC.

## Screenshots

![Widget Screenshot](https://s3-eu-west-1.amazonaws.com/geekproject/screenshots/piwik-barometer-01.png)

![Widget Screenshot](https://s3-eu-west-1.amazonaws.com/geekproject/screenshots/piwik-barometer-02.png)

## Documentation

1. Clone the plugin into the plugins directory of your Piwik installation.

   ```
   cd plugins/
   git clone https://github.com/halfdan/piwik-barometer-plugin.git Barometer
   ```

2. Login as superuser into your Piwik installation and activate the plugin under Settings -> Plugins

3. You will now find the widget under Live! -> Visitor Barometer

## Contribute 

If you are interested in contributing to this plugin, feel free to send pull requests!
