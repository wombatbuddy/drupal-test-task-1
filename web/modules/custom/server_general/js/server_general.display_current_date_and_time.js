/**
 * @file
 * Server General behaviors.
 */
(function (Drupal, once) {

  'use strict';

  Drupal.behaviors.serverGeneralDisplayCurrentDateAndTime = {
    attach (context, settings) {
      const header = once('display-current-date-and-time', '#header', context).shift();
      if (header) {
        const div = document.createElement('div');
        div.setAttribute('id', 'current-date-time');
        header.insertAdjacentElement('beforeend', div);
        setInterval(() => {
          const now = new Date();
          div.textContent = now.toLocaleString();
        }, 1000);
      }
    }
  };

} (Drupal, once));
