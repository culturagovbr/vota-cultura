const Menu = [
  {
    title: 'Início',
    group: 'apps',
    icon: 'home',
    to: 'inicio',
  },
  { header: 'Inscreva-se' },
  {
    title: 'Organização ou Entidade Cultural',
    group: 'apps',
    name: 'Organização ou Entidade Cultural',
    icon: 'color_lens',
  },
  {
    title: 'Conselhos de Cultura',
    group: 'apps',
    name: 'Conselho de Cultura',
    icon: 'group',
  },
  {
    title: 'Eleitor',
    group: 'apps',
    name: 'Eleitor',
    icon: 'thumbs_up_down',
  },
];
// reorder menu
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
