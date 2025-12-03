import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import 'bootstrap';
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';

// const blockButton = document.getElementById("block-button")
// const unlockButton = document.getElementById("unlock-button")
// const deleteButton = document.getElementById("delete-button")
// const deleteUnverifiedButton = document.getElementById("delete-unverified-button")
//
// blockButton.addEventListener('click', createInputFieldForSubmitData)
// unlockButton.addEventListener('click', createInputFieldForSubmitData)
// deleteButton.addEventListener('click', createInputFieldForSubmitData)
// deleteUnverifiedButton.addEventListener('click', createInputFieldForSubmitData)
//
// function createInputFieldForSubmitData(event){
//         let form = event.currentTarget.form
//         const old = form.querySelector('input[name="data"]');
//         if (old) old.remove();
//
//         let ids = collectInputCheckbox()
//         const hidden = document.createElement('input');
//         hidden.type = 'hidden';
//         hidden.name = 'data';
//         hidden.value = JSON.stringify(ids);
//
//         form.appendChild(hidden);
//         form.submit();
// }
//
// let checkboxGroup = document.getElementsByName('ids')
// checkboxGroup.forEach((item) => {
//     item.addEventListener('click', collectInputCheckbox)
// })
//
// function collectInputCheckbox(){
//     let checkboxGroup = document.getElementsByName('ids')
//     let selectChekboxGroup = Array.from(checkboxGroup).filter(item => item.checked === true)
//     let ids = selectChekboxGroup.map(item => item.value)
//     return ids;
// }
//
// const checkboxMulti = document.getElementById('checkboxMulti');
// checkboxMulti.checked = false
// checkboxMulti.addEventListener('click', () => {
//     let check = checkboxMulti.checked
//     selectAllCheckbox(check)
// })
//
// function selectAllCheckbox(checked = false){
//     let users = document.querySelectorAll('tr.user')
//     let visibleUsers = Array.from(users).filter(user => {
//         return getComputedStyle(user).display !== "none";
//     })
//     let checkboxGroup = visibleUsers.map(item => item.querySelector("input[name='ids']"))
//     Array.from(checkboxGroup).forEach(item => item.checked = checked)
// }
//
// const filterInput = document.getElementById('filter-input')
// filterInput.addEventListener('input', ()=> {
//     let users = document.querySelectorAll('tr.user')
//     for (let i = 0; i < users.length; i++){
//         let allColumns = users[i].children
//         for (let y = 1; y < allColumns.length; y++){
//             let txtContent = allColumns[y].textContent.trim().toLowerCase()
//             if (txtContent.indexOf(filterInput.value.toLowerCase()) > -1) {
//                 users[i].style.display = "";
//                 break;
//             } else {
//                 users[i].style.display = "none";
//             }
//
//         }
//     }
// })
//
// selectAllCheckbox(false)
// filterInput.value = ''
