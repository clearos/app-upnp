
Name: app-miniupnp
Epoch: 1
Version: 1.0.0
Release: 1%{dist}
Summary: MiniUPnP
License: GPLv3
Group: ClearOS/Apps
Packager: Peter Baldwin
Vendor: Peter Baldwin
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base
Requires: app-network

%description
MiniUPnP - a description goes here.

%package core
Summary: MiniUPnP - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: miniupnpd

%description core
MiniUPnP - a description goes here.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/miniupnp
cp -r * %{buildroot}/usr/clearos/apps/miniupnp/

install -d -m 0755 %{buildroot}/var/clearos/miniupnp
install -d -m 0755 %{buildroot}/var/clearos/miniupnp/backup
install -D -m 0644 packaging/miniupnpd.php %{buildroot}/var/clearos/base/daemon/miniupnpd.php

%post
logger -p local6.notice -t installer 'app-miniupnp - installing'

%post core
logger -p local6.notice -t installer 'app-miniupnp-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/miniupnp/deploy/install ] && /usr/clearos/apps/miniupnp/deploy/install
fi

[ -x /usr/clearos/apps/miniupnp/deploy/upgrade ] && /usr/clearos/apps/miniupnp/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-miniupnp - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-miniupnp-core - uninstalling'
    [ -x /usr/clearos/apps/miniupnp/deploy/uninstall ] && /usr/clearos/apps/miniupnp/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/miniupnp/controllers
/usr/clearos/apps/miniupnp/htdocs
/usr/clearos/apps/miniupnp/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/miniupnp/packaging
%exclude /usr/clearos/apps/miniupnp/tests
%dir /usr/clearos/apps/miniupnp
%dir /var/clearos/miniupnp
%dir /var/clearos/miniupnp/backup
/usr/clearos/apps/miniupnp/deploy
/usr/clearos/apps/miniupnp/language
/usr/clearos/apps/miniupnp/libraries
/var/clearos/base/daemon/miniupnpd.php
