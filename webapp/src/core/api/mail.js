import * as User from './user';

const MailItem = [
  {
    uuid: 'bb428c03-1bc6-4f3d-9d5e-268ec44eebc3',
    type: 'trashed',
    tag: 'Promotion',
    title: 'Similique voluptate laboriosam laborum.',
    created_at: '2018-04-10T23:10:41.266Z',
    content:
      'Tempora et optio quis ducimus. Veniam et qui quia ut necessitatibus architecto ad. Vel ut consequatur non'
      + ' sint est error sint.\n \rError asperiores a esse ad. Rerum eum magni aperiam voluptas excepturi. Suscipit'
      + ' est modi magni et ut eum ut.\n \rCumque eius voluptatem sit qui nisi. Eos eum est cumque est ipsa odit earum '
      + 'voluptas. Dolorum ipsam rerum ut.\n \rAutem quia delectus quia rerum deleniti reprehenderit voluptatibus '
      + 'quisquam. Necessitatibus molestias vel odio neque expedita nulla libero voluptatem numquam. In labore modi.'
      + ' Unde molestiae id molestias vero delectus rerum nesciunt voluptatum exercitationem.\n \rCorrupti '
      + 'et voluptatibus ea dolorem laboriosam. Amet cupiditate beatae nulla. Facilis sit est. Sed ducimus '
      + 'ducimus alias rem nam.',
    fromId: '14ddae1e-986d-42f4-8d17-46a02d469b2b',
    attachments: [],
  },
  {
    uuid: 'a19bf9fc-e877-49e7-a75a-b089a2c35f18',
    type: 'draft',
    tag: 'Social',
    title: 'Ipsum maiores ab amet voluptas enim.',
    created_at: '2018-04-10T12:05:32.328Z',
    content:
      'Dolores corporis quam perferendis consequatur autem minus recusandae non. Id corrupti qui et. Sed a '
      + 'accusamus veritatis earum et consequatur mollitia. Iure consequatur omnis aspernatur itaque laboriosam'
      + ' aut ut. Enim repellendus sed similique minima voluptatem sed ea. Exercitationem aut est eius rerum.\n \rUt'
      + ' veniam quidem et numquam reprehenderit aliquam. Omnis eos qui enim hic modi maiores. Nisi itaque '
      + 'et unde ullam laborum ut aut facilis. Enim qui aut est.\n \rTotam molestiae velit aperiam rerum. '
      + 'Voluptatum quo ab. Quae cupiditate sit quia illum delectus nobis adipisci sunt.\n \rAlias nostrum '
      + 'ad ipsam aut nulla et repudiandae incidunt doloribus. Vero rerum omnis. Consequatur eius et accusamus'
      + ' quaerat et unde animi. Sed et quaerat sit quis mollitia. Accusantium voluptatem perferendis qui enim '
      + 'similique molestiae ut sit velit.\n \rProvident quibusdam excepturi asperiores vitae earum ut fugiat. '
      + 'Eligendi illum nisi dolor. Maiores velit vitae minus.',
    fromId: '60d07662-bfec-42c7-b044-c81bc4ff8c7a',
    attachments: [],
  },
];

// add user to mail
MailItem.map((item) => {
  const users = User.getUser();
  /* eslint-disable no-param-reassign */
  item.from = users.find(x => x.uuid === item.fromId);
  return item;
});
//

const MailMenu = [
  {
    title: 'Email',
    group: 'email',
    icon: 'email',
    to: { path: '/mail/all' },
    chip: 10,
  },
  {
    title: 'Sent',
    group: 'email',
    icon: 'send',
    to: { path: '/mail/sent' },
    chip: 5,
  },
  {
    title: 'Starred',
    group: 'email',
    icon: 'star',
    to: { path: '/mail/starred' },
    chip: 2,
  },
  {
    title: 'Draft',
    group: 'email',
    icon: 'content_copy',
    to: { path: '/mail/draft' },
    chip: 3,
  },
  {
    title: 'Trash',
    group: 'email',
    icon: 'delete',
    to: { path: '/mail/trashed' },
    chip: 1,
  },
  { heading: 'Label' },
  {
    icon: 'radio_button_checked',
    iconColor: 'yellow',
    title: 'Work',
    iconSize: 'small',
  },
  {
    icon: 'radio_button_checked',
    iconColor: 'green',
    title: 'Client',
    iconSize: 'small',
  },
  {
    icon: 'radio_button_checked',
    iconColor: 'red',
    title: 'Project',
    iconSize: 'small',
  },
  {
    icon: 'radio_button_checked',
    iconColor: 'grey',
    title: 'Peronal',
    iconSize: 'small',
  },
];

const getMail = limit => (limit ? MailItem.slice(0, limit) : MailItem);

const getMailById = uuid => (uuid === undefined ? MailItem[0] : MailItem.find(x => x.uuid === uuid));

const getMailByType = type => (type === 'all' ? MailItem : MailItem.filter(x => x.type === type));
export {
  getMail, MailMenu, getMailById, getMailByType,
};
