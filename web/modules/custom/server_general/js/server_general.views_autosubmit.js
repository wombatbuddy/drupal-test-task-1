/**
 * @file
 * JavaScript behaviors for views autosubmit.
 */
(function (Drupal, drupalSettings, once) {

  'use strict';

  /**
   * Hide a submit button and add autosubmit feature to the views exposed form.
   *
   * @type {Drupal~behavior}
   *
   */
  Drupal.behaviors.serverGeneralViewsAutosubmit = {
    attach (context, settings) {
      // Exposed filter IDs for which we need to implement autosubmit.
      const submitButtonID = drupalSettings.serverGeneral.viewsAutosubmit.submitButtonID;
      // Since after the Ajax response a suffix can be added to the "id"
      // attribute, we use the condition "^=" (starts with) in the selector.
      const submitButtonSelector = `[id^="${submitButtonID}"]`;
      const submitButton = once('views-autosubmit', submitButtonSelector, context).shift();
      if (submitButton === undefined) {
        return;
      }
      // Hide submit button.
      submitButton.style.display = "none";
      const exposedFilterIDs = drupalSettings.serverGeneral.viewsAutosubmit.exposedFilterIDs;
      exposedFilterIDs.forEach((filterID) => {
        // Since after the Ajax response a suffix can be added to the "id"
        // attribute, we use the condition "^=" (starts with) in the selector.
        const selector = `[id^="edit-${filterID}"]`;
        const exposedFilterElement = document.querySelector(selector);
        if (exposedFilterElement) {
          exposedFilterElement.addEventListener('change', () => submitButton.click());
        }
      });
    }
  };

} (Drupal, drupalSettings, once));
