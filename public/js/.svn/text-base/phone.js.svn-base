

function isInteger(s)
{ var i;
for (i = 0; i < s.length; i++)
{
// Check that current character is number.
var c = s.charAt(i);
if (((c < "0") || (c > "9"))) return false;
}
// All characters are numbers.
return true;
}
function stripCharsInBag(s, bag)
{ var i;
var returnString = "";
// Search through string's characters one by one.
// If character is not in bag, append to returnString.
for (i = 0; i < s.length; i++)
{
// Check that current character isn't whitespace.
var c = s.charAt(i);
if (bag.indexOf(c) == -1) returnString += c;
}
return returnString;
}