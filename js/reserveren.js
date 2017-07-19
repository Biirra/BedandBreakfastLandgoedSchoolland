/**
 * Created by JanWillem Huising on 22-5-2017.
 */
var aanvang = new Date().toISOString().split('T')[0];
document.getElementsByName("aanvang-datum")[0].setAttribute('min', aanvang);

var vertrek = new Date().toISOString().split('T')[0];
document.getElementsByName("vertrek-datum")[0].setAttribute('min', vertrek);