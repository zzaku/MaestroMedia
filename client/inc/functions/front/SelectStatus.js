  // Récupérer tous les éléments avec la classe "option-status"
  const optionStatusElements = document.querySelectorAll('.option-status');

  // Ajouter un écouteur d'événements pour chaque élément
  optionStatusElements.forEach((element) => {
    element.addEventListener('click', () => {
      // Supprimer l'attribut "checked" de tous les éléments
      optionStatusElements.forEach((el) => {
        el.querySelector('input').checked = false;
        el.style.removeProperty('background');
      });

      // Cocher l'élément cliqué en définissant son attribut "checked" à true
      element.querySelector('input').checked = true;
      const computedStyle = getComputedStyle(element);
      element.style.background = computedStyle.backgroundColor;
    });
  });