
function RV_securityCheck(adminPath, callback = null) {
    var paths = [
            'var/INSTALLED',
            'var/cache/README.txt',
            'etc/database_action.xml',
            'plugins/etc/openXDeliveryLog.xml',
            'lib/RV.php'
        ],
        done = paths.length;
        errors = [],
        dest = adminPath + 'maintenance-security.php';

    if (!callback) {
        callback = function (errors) {
            if (!errors.length) {
                return;
            }

            location.href = dest;
        };
    }

    $(paths).each(function (i, path) {
        var c = path,
            u = adminPath + '../../' + c;

        $.ajax({
            url: u,
            error: function () {
            },
            success: function () {
                errors.push(c);
            },
            complete: function () {
                if (--done) {
                    return;
                }

                callback(errors);
            }
        });
    });
}
