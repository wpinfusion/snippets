// Validate a (Dutch) BSN numer with JavaScript in a Bookly Custom Field
// Note: minify and insert into text on Bookly > Appearance (like with Google Analytics)

const input=document.querySelector(".bookly-custom-field-row[data-id='9038'] input"); // CHange to correct data-id
const submitButton=document.getElementsByClassName("bookly-next-step")?.[0];
const submitNotice=document.getElementsByClassName("bookly-bsn-notice")?.[0];

input.id = 'bsnval';
input.type = 'number';
input.min = 9999999;
input.max = 999999999;
input.onkeypress = "return event.charCode >= 48 && event.charCode <= 57";
input.addEventListener( 'input' , validateBSN );

function validateBSN() {
  let bsn = document.getElementById("bsnval").value;
  if (!bsn) {
    return;
  }
  
  bsn = bsn.padStart( 9, '0' ).split('').reduce( (sum, int, i) => sum + (9 - i) * int, 0 ) - 2 * bsn[8];

  if (isNaN( bsn ) || bsn % 11 || input.value.length > 9 || input.value.length < 8) {
    //invalid
    submitNotice.classList.remove("bookly-display-none");
    submitButton.classList.add("bookly-display-none");
  } else {
    //valid
    submitNotice.classList.add("bookly-display-none");
    submitButton.classList.remove("bookly-display-none");
  }
}
