document.addEventListener("DOMContentLoaded", function () {
// Процедуры

   // Эта функция делает AJAX запрос. Она универсальна, при большинстве случаев.
	const postData = async ( url = "", data = {}, method = "POST") => {
		//Собственно сам запрос
		const response = await fetch(url, {
			method: `${method}`,// *GET, POST, PUT, DELETE, etc.
			headers: {
				//'Content-Type': 'multipart/form-data',
				//'Content-Type': 'application/json',
				// 'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: data, 
		});

      // Если ответ не 200 - 299, то выбрасывает ошибку.
      if (!response.ok) {
         const message = `An error has occured: ${response.status}`;
         throw new Error(message);
      }

      // Если  все хорошо, то парсим JSON и возвращаем его.
      const json = response.json(); 
      return json;
	};


// Объявляем переменные
	const forms = document.querySelectorAll('form');
   const blockError = document.querySelector('.block-error');
   const exitUserButton = document.querySelector('#exit-user');
   const deleteLinkButton = document.querySelectorAll('.short-link__button');

// Программы

   // Для каждой формы повесили событие, которое будет отправлять данные формы AJAX запросом на сервер.
	forms.forEach((form) => {

		form.onsubmit = function (e) {

         e.preventDefault();
         //const method = e.target.method;
         const url= e.target.action
         const data = new FormData(this);

         // AJAX - запрос
         postData(url, data)
            .then((data) => {
               console.log(data);

               if (data.url) {
                  blockError.classList.add('d-none');
                  window.location.href = data.url
               } else {
               blockError.classList.remove('d-none');
               blockError.innerHTML = `${data.status}: ${data.message}`;
               }
               
            })
            .catch((error) => {
               console.log(error.message);
            });
         e.target.reset();
      };
      
	});

   // При нажатии на кнопку отправляем запрос и потом выходим из кабинета.
   if (exitUserButton) {
   exitUserButton.onclick = function (e) {
      e.preventDefault();
      
      // Делаем AJAX 
      postData('/account/exit')
         .then((data) => {

            if (data.url) {
               window.location.href = data.url
            } else {
            blockError.innerHTML = `${data.status}: ${data.message}`;
            }
            
         })
         .catch((error) => {
            console.log(error.message);
         });
   }
   }
   
   // Вешаем на каждую кнопку событие, затем при нажатии формируем AJAX запрос с JSON 
   deleteLinkButton.forEach((button) => {
      button.onclick = function (e) {

         e.preventDefault();
         const url= '/link/delete';
         const data = {'short_link': e.target.id};
         let json = JSON.stringify(data);

         // Делаем AJAX 
         postData(url, json)
         .then((data) => {
            console.log(data);

            if (data.url) {
               window.location.href = data.url
            } else {
            blockError.innerHTML = `${data.status}: ${data.message}`;
            }
            
         })
         .catch((error) => {
            console.log(error.message);
         });

      }

   });
});