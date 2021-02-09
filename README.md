## Descrição

REST API para gerenciamento de contatos utilizando Slim Framework, componentes Eloquent, Validation do Laravel, JWT para autenticação e banco de dados SQLite.

Versão utilizada do PHP 7.4.13

## Estrutura do projeto

![Estrutura projeto](https://github.com/adevecchi/slim-eloquent-rest-api/blob/main/public/images/screenshot/estrutura.png)

## Endpoints

* Login: `POST /login`

![Login](https://github.com/adevecchi/slim-eloquent-rest-api/blob/main/public/images/screenshot/login.png)

---

* Novo contato: `POST /api/contacts`

![Novo contato](https://github.com/adevecchi/slim-eloquent-rest-api/blob/main/public/images/screenshot/contacts-post.png)

---

* Todos contatos: `GET /api/contacts`

![Todos clientes](https://github.com/adevecchi/slim-eloquent-rest-api/blob/main/public/images/screenshot/contacts-get.png)

---

* Contato por Id: `GET /api/contacts/{id}`

![Contato por id](https://github.com/adevecchi/slim-eloquent-rest-api/blob/main/public/images/screenshot/contacts-get-id.png)

---

* Atualiza contato: `PUT /api/contacts/{id}`

![Atualiza contato](https://github.com/adevecchi/slim-eloquent-rest-api/blob/main/public/images/screenshot/contacts-put.png)
 
---

* Remove contato: `DELETE /api/contacts/{id}`

![Remove contacts](https://github.com/adevecchi/slim-eloquent-rest-api/blob/main/public/images/screenshot/contacts-delete.png)
