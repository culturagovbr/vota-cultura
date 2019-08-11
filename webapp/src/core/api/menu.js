const Menu = [
  {
    title: 'Início',
    group: 'apps',
    icon: 'home',
    name: 'Inicio',
  },
];

Menu.forEach((item) => {
  if (item.items) {
    item.items.sort((x, y) => {
      const textA = x.title.toUpperCase();
      const textB = y.title.toUpperCase();
      /* eslint-disable */
      return textA < textB ? -1 : textA > textB ? 1 : 0;
    });
  }
});

export default Menu;
