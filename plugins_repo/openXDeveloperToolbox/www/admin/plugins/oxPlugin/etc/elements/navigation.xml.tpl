        <navigation>

            <!-- a menu is cached for each role -->
            <!-- add= will add a top level menu item -->
            <!-- core menu is defined in lib/OA/Admin/Menu/config.php -->
            <admin>
                <menu add="{GROUP}-menu"   link="plugins/{GROUP}/{GROUP}-index.php">{GROUP} Plugin</menu>
                <menu addto="{GROUP}-menu" index="{GROUP}-menu-i" link="plugins/{GROUP}/{GROUP}-index.php">{GROUP} Admin Index</menu>
            </admin>

            <manager>
                <menu add="{GROUP}-menu"   link="plugins/{GROUP}/{GROUP}-index.php">{GROUP} Plugin</menu>
                <menu addto="{GROUP}-menu" index="{GROUP}-menu-i" link="plugins/{GROUP}/{GROUP}-index.php">{GROUP} Manager Index</menu>
            </manager>

            <advertiser>
                <menu add="{GROUP}-menu"   link="plugins/{GROUP}/{GROUP}-index.php">{GROUP} Plugin</menu>
                <menu addto="{GROUP}-menu" index="{GROUP}-menu-i" link="plugins/{GROUP}/{GROUP}-index.php">{GROUP} Advertiser Index</menu>
            </advertiser>

            <trafficker>
                <menu add="{GROUP}-menu"   link="plugins/{GROUP}/{GROUP}-index.php">{GROUP} Plugin</menu>
                <menu addto="{GROUP}-menu" index="{GROUP}-menu-i" link="plugins/{GROUP}/{GROUP}-index.php">{GROUP} Trafficker Index</menu>
            </trafficker>

        </navigation>