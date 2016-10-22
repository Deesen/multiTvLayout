## Installation

1. Install MultiTV as normal
2. Copy all files from MultiTvLayout-ZIP to your MODX-installation (overwrite all files)
3. Create new TV with Type "MultiTV" and name "multiTvLayout"
4. Create new Snippet "multiTvLayout" and paste content of snippet.multiTvLayout.php
5. Optional: Setup Manager-CSS inside `multiTvLayout.config.inc.php`
     - by default Bootstrap3 is used
     - in multitv/setting/datatable.setting.inc.php CSS-files can be changed
6. Optional: Rename `js/jquery-dataTables.rowReordering-1.1.0.js.BUGFIX` to enable row-reordering (req. for MODX 1.2+ & multiTV 2.0.8-)


## Setup

The shipped row-templates are using Bootstrap 3. You can modify them using your own framework. multiTvLayout is organized as follows:

`configs/multiTvLayout.config.inc.php` is a extended variant of a multiTV-Configuration. Additional details that can be set beside normal multiTV-options:

- **previewPath** Path to row-thumbnails
- **layoutId** Key used for template-files like `multiTvLayout.bootstrap3.l1.php`
- additional CSS-Files to inject inside Manager for display the CSS-framework correct (Bootstrap Columns, Image-Classes etc)

`configs/layouts/multiTvLayout.bootstrap3.php` allows dynamic change of different values like generally adding `<span class="head"></span>` around your headlines. PHP-knowledge required!

`configs/layouts/multiTvLayout.bootstrap3.l1.php` l1, l2.. and so on are the row-templates that can be set for each row independently.


## Usage

When you have set up your page via multiTvLayout, you can render the HTML-output using the snippet
 
    [[multiTvLayout?
        &tvName=`multiTvLayout`
        &id=`[*id*]`
        &layoutId=`bootstrap3`
        &container=`container`
        &noContent=`No content given`
    ]]

Thanks to multiTv´s flexibility it is possible to use multiple multiTvLayout on the same page, like main-content and side-column.

## Multilanguage / YAMS

Multilanguage-usage as well as YAMS-compatibility is already prepared (and definetly possible) but not finished yet.