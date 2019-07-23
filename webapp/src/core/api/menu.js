const Menu = [
  {
    title: 'Início',
    group: 'apps',
    icon: 'home',
    name: 'Inicio',
  },
  { header: 'Inscreva-se' },
  {
    title: 'Organização ou Entidade Cultural',
    group: 'apps',
    name: 'Organizacao',
    icon: 'color_lens',
  },
  {
    title: 'Conselhos de Cultura',
    group: 'apps',
    name: 'Conselho',
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
