Report Generator
=============
This plugins goal is to gather information for any site that it has been installed in.
All the relevant information is stored which can then be viewed on a webpage or converted to a PDF by the push of a button.
Thanks to Synergy Learning for the idea and in particular Peter Hinds.

Usage
=============
Once the plugin has been installed navigate to the local plugin in directory and select on the "Report Generator" option.
From there you will be able to choose the information you would like to receive on the report. Make sure to always save the options you selected.
Then you can choose how you would like to view the report. Either through a PDF or on a web page.

Run Unit tests
==============
In order to run the unit tests make sure the PHPUnit environment is set up.
Run the following command in the project folder. Change the "source_database_test.php" to any test you want to run.
XDEBUG_CONFIG="idekey=PHPSTORM" vendor/bin/phpunit local/reportgen/tests/source_database_test.php


Disclaimer
=============
This repository is provided as-is and is open to pull requests or issues.
It was developed by Christopher Logan for the use at [Synergy Learning] (https://www.synergy-learning.com/)
If you find any problems or new features that could be added to the plugin please fill out the FEEDBACK_TEMPLATE.