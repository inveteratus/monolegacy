# Monolegacy

Forked from [davemacaulay/mccodesv2](https://github.com/davemacaulay/mccodesv2/tree/v2.0.5b), Monolegacy is a simple browser game written in PHP where players commit
crimes, trade and fight one-another in an effort to "**be the best**".

Since support for the original game died a long time ago, and there appears to be little or no activity over at
[MakeWebGames](https://makewebgames.io/forum/32-mccodes/), I've created this repo, ignoring the changes made by [Dave Macaulay](https://github.com/davemacaulay) and [Anthony](https://github.com/Magictallguy) as
their contributions will get superseded as I work on this code-base.

The plans are relatively simple - not necessarily in order:

* Add support for a local docker setup for local development
* Get the code base working "as-is"
* Cleanup the code using up-to-date code style
* Correct static analysis issues
* Add some default content so we can play-test the code
* Move to class-based code
* Use a templating system instead of inline HTML
* Write some basic unit and feature tests
* Make a front-end controller using PSR7/PSR15
* Create a modular plugin system for future modules
* Remove the current cron system
