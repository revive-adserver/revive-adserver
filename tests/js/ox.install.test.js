const assert = require('assert');
const fs = require('fs');
const vm = require('vm');

const jquery = function () {
    return {
        append: function () { return this; },
        html: function () { return this; },
        text: function () { return this; },
        ajaxJobs: function (options) {
            const error = new Error('Request could not be started');
            options.exception(0, '/installer/task', error);
            options.allComplete(1);
        }
    };
};
jquery.fn = {};
jquery.extend = function (target, defaults, options) {
    return Object.assign(target, defaults, options);
};

const context = {
    jQuery: jquery,
    document: {},
    console: console
};
vm.runInNewContext(
    fs.readFileSync('www/admin/assets/js/ox.install.js', 'utf8'),
    context,
    { filename: 'ox.install.js' }
);

let completion;
jquery.fn.installTasks({
    jobs: [{ id: 'createAdmin', name: 'Create administrator', url: '/installer/task' }],
    loaderId: 'loader',
    errorContainerId: 'errors',
    allComplete: function (count, errors) {
        completion = { count: count, errors: errors };
    }
});

assert.strictEqual(completion.count, 1);
assert.strictEqual(completion.errors.length, 1);
assert.strictEqual(completion.errors[0].id, 'createAdmin');
assert.strictEqual(completion.errors[0].message, 'Error: Request could not be started');

console.log('Installer task exception regression test passed');
