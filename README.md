# icingaweb2-module-statusmap

This is a very basic status map module for Icingaweb 2.

## Installation

To install, check out this repo to your icingaweb2 modules directory:
```bash
git clone https://github.com/invliD/icingaweb2-module-statusmap.git /usr/share/icingaweb2/modules/statusmap
```

In addition, the monitoring module does not contain a few IDO model classes, so you need to link the IDO classes into that module:
```bash
ln -s ../../../../../../statusmap/library/Monitoring/Backend/Ido/Query/HostdependencyQuery.php /usr/share/icingaweb2/modules/monitoring/library/Monitoring/Backend/Ido/Query/HostdependencyQuery.php
```

## Contributing
If you want to contribute to this project:

- Fork the repository
- Hack your changes
- Submit a Pull Request
