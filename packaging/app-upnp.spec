
Name: app-upnp
Epoch: 1
Version: 1.0.0
Release: 1%{dist}
Summary: UPnP
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
The UPnP app provides both UPnP and NAT-PMP connectivity support.  This feature is used by some software applications including instant messaging.

%package core
Summary: UPnP - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: miniupnpd

%description core
The UPnP app provides both UPnP and NAT-PMP connectivity support.  This feature is used by some software applications including instant messaging.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/upnp
cp -r * %{buildroot}/usr/clearos/apps/upnp/

install -d -m 0755 %{buildroot}/var/clearos/upnp
install -d -m 0755 %{buildroot}/var/clearos/upnp/backup
install -D -m 0644 packaging/miniupnpd.php %{buildroot}/var/clearos/base/daemon/miniupnpd.php

%post
logger -p local6.notice -t installer 'app-upnp - installing'

%post core
logger -p local6.notice -t installer 'app-upnp-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/upnp/deploy/install ] && /usr/clearos/apps/upnp/deploy/install
fi

[ -x /usr/clearos/apps/upnp/deploy/upgrade ] && /usr/clearos/apps/upnp/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-upnp - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-upnp-core - uninstalling'
    [ -x /usr/clearos/apps/upnp/deploy/uninstall ] && /usr/clearos/apps/upnp/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/upnp/controllers
/usr/clearos/apps/upnp/htdocs
/usr/clearos/apps/upnp/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/upnp/packaging
%exclude /usr/clearos/apps/upnp/tests
%dir /usr/clearos/apps/upnp
%dir /var/clearos/upnp
%dir /var/clearos/upnp/backup
/usr/clearos/apps/upnp/deploy
/usr/clearos/apps/upnp/language
/usr/clearos/apps/upnp/libraries
/var/clearos/base/daemon/miniupnpd.php
