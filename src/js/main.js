window.addEventListener("load", (event) => {

  /**
   * Email protection
   * @link https://jsfiddle.net/fedek6/pzukv3so/
   */
  const emails = document.querySelectorAll("[data-email-protection='true']");
  const separator = "[małpa]";

  for (const email of emails) {
    if (email.textContent) {
      const textContent = email.textContent;
      const properEmail = textContent.replace(separator, "@");
      const replacement = document.createElement("a");
      replacement.setAttribute("href", "mailto:" + properEmail);
      replacement.textContent = properEmail;
      email.replaceWith(replacement);
    }
  }
});
