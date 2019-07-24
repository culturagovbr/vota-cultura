
## Estrutura de diret&oacute;rios atual (aguardando contribuição)

A estrutura inicial definida é a seguinte:

```
├── index.html
├── main.js
├── api
│   └── ... # abstrações para fazer solicitações de API
├── components
│   ├── App.vue
│   └── ...
└── store
    ├── index.js          # onde montamos módulos e exportamos a configs da store
    ├── actions.js        # root actions
    ├── mutations.js      # root mutations
    └── modules
        ├── app.js      # store geral do app
        ├── login.js    # login module
        └── product.js  # produto module
```

O eslint sinaliza diversas recomendações do style guide do vue, aqui iremos detalhar apenas as recomendações que ele não trata. 

## Padronização da nomenclatura de componentes

O nome do componente deve utilizar o padrão `PascalCase`

```
components/
   |- MyComponent.vue
```

Quando o componente é único deve iniciar com o prefixo `The`.

```
components/
|- TheHeading.vue
|- TheSidebar.vue
```

Componentes filhos que são fortemente acoplados a seus pais devem incluir o nome do componente pai como um prefixo.

```
components/
|- TodoList.vue
|- TodoListItem.vue
|- TodoListItemButton.vue

```

Os componentes devem iniciar com nomes de níveis mais altos e finalizar com nomes mais descritivos

```
components/
|- SearchButtonClear.vue
|- SearchButtonRun.vue
|- SearchInputQuery.vue
|- SearchInputExcludeGlob.vue
|- SettingsCheckboxTerms.vue
|- SettingsCheckboxLaunchOnStartup.vue
```

Evitar abreviação nos nomes

```
components/
|- StudentDashboardSettings.vue
|- UserProfileOptions.vue
```


## Props

O nome das props devem ser no padrão `camelCase`.

```
props: {
  greetingText: {
     type: String,
     defult: ''
  } 
}
```

Para utilizar a prop no template

```
<WelcomeMessage greeting-text="hi"/>
```

