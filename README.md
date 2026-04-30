# Addon Installer

Addon Installer is an ExpressionEngine 7 control panel add-on for managing
third-party add-on ZIP packages from inside the control panel. It uploads ZIPs,
detects the real add-on folder, extracts files into the active add-ons directory,
and then hands install, update, settings, and uninstall actions back to
ExpressionEngine's normal add-on manager flow.

## Features

- Upload ExpressionEngine add-on ZIP packages from the control panel.
- Detect the add-on folder by locating `addon.setup.php`, including inside a
  wrapper folder.
- Reject unsafe ZIP paths, including absolute paths and `..` traversal.
- Optionally overwrite an existing add-on folder with the same short name.
- List detected add-ons as responsive cards with status tags.
- Sort not-installed add-ons before installed add-ons.
- Install, update, uninstall, download, and settings actions with compact icons.
- Show Update Available when overwritten files contain a newer version.
- Enable Settings only when an installed add-on declares a settings page.
- Generate package downloads on demand without permanently storing ZIP files.
- Include a control panel documentation page and bundled add-on icon.

## Requirements

- ExpressionEngine 7.
- PHP `ZipArchive`.
- A writable ExpressionEngine add-ons directory.
- Control panel access with permission to manage add-ons.

## Installation

1. Copy `addon_installer/` into `system/user/addons/`.
2. In ExpressionEngine, open Developer > Add-Ons.
3. Install Addon Installer.
4. Open Addon Installer from the add-on settings page.

## Package Format

The ZIP should contain one add-on folder named with the add-on short name:

```text
my_addon/
  addon.setup.php
  upd.my_addon.php
  mcp.my_addon.php
  ...
```

Wrapper folders are allowed:

```text
downloaded-release/
  my_addon/
    addon.setup.php
    upd.my_addon.php
```

Loose add-on files at the ZIP root are rejected because the installer cannot
infer the destination folder name. Valid add-on folder names use lowercase
letters, numbers, and underscores.

## Usage

Upload a ZIP from Install ZIP. If the package is new, click the install icon on
the Packages screen or in the upload success notice. If you overwrite an
installed add-on with a newer version, click the update icon to run
ExpressionEngine's update step.

The Packages screen shows:

- Installed, Not Installed, or Update Available status.
- Install icon for not-installed add-ons.
- Update icon when a newer installed version is available.
- Download icon for every detected add-on.
- Settings icon only when settings are available.
- Red uninstall icon for installed add-ons.

## Development

Run PHP lint after editing PHP files:

```bash
for f in *.php ControlPanel/*.php ControlPanel/Routes/*.php Service/*.php views/*.php; do php -l "$f" || exit 1; done
```

`AGENTS.md` is local development guidance and is intentionally ignored by this
add-on repository.

## Notes

Addon Installer extracts packages and builds convenience links only.
ExpressionEngine remains responsible for final install, update, settings, and
uninstall behavior.
