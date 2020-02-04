import helpers from './helpers'
export default {
    mixins: ['helpers'],
    get(key, _default) {
        _default = (typeof _default == 'undefined')? '' : _default;
        return helpers.toJson(localStorage.getItem(key), _default)
    },

    set(key, val) {
        localStorage.setItem(key, JSON.stringify(helpers.toJson(val,{})));
    },

    remove(key) {
        localStorage.removeItem(key)
    },

}

/* export default {
    get(key, _default) {
        _default = (typeof _default == 'undefined') ? '' : _default;
        return localStorage.getItem(key);
    },

    getAsJson(key, _default) {
        _default = (typeof _default == 'undefined') ? '' : _default;
        return helpers.toJson(localStorage.getItem(key), _default)
    },

    set(key, val) {
        localStorage.setItem(key, val);
    },

    setAsJason(key, val) {
        localStorage.setItem(key, JSON.stringify(helpers.toJson(val, {})));
    },

    remove(key) {
        localStorage.removeItem(key)
    }
} */