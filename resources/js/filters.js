import moment from 'moment';

Vue.filter('upcase', function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('formatDate', function (date) {
    return date.moment().format('MMM Do YY')
})