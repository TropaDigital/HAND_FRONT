// Deal with vendor prefixes
var connection = window.navigator.connection    ||
                 window.navigator.mozConnection ||
                 null;
if (connection === null) {
   console.log('deu ruim');
} else {
   // API supported! Let's start the fun :)
}