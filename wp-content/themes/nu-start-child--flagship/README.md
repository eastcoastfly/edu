# NU-Start Child Theme

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.


# Overview

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

## Overview

Codekit watches `/source/*` and automatically builds it to `/build/*`
[Sass Partials](https://sass-lang.com/guide) are used and adding new scripts or stylesheets is not recommended.

## Install and Setup

After extracting theme and setting up any local environment and/or Git configurations...

 - Using Codekit is the preferred build process
	 - Simply launch the codekit.config file and everything is ready
	 - Import any partials needed into the main stylesheet and script files
 - If Codekit is not available an NPM build process is included and requires:
	 - Node.js
 - OPTIONAL INCLUDES:
	 - Composer:
		 - At this time, composer only includes VS Code Intelliphense stubs
	 - Misc.
		 - An .editorconfig file is included if your editor supports it
 - Using NPM and Laravel Mix
	 - `npm install`
	 - use `npx mix` to compile for development
	 - use `npx mix --production` to compile for live
	 - use `npx mix watch` to enable file watching and browsersync