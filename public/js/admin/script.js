function ajaxFunc(responseText) {
    console.log(responseText);
    member.innerHTML = null;
    if (responseText != null) {
        var data = JSON.parse(responseText);

        keys = Object.keys(data);
        if (keys.length) {
            keys.forEach(function (key) {
                var a = document.createElement("a");
                a.setAttribute("href", "#");

                var card = document.createElement("div");
                card.setAttribute("class", "card member-card");
                a.appendChild(card);

                var h5 = document.createElement("h5");
                h5.innerHTML = data[key].username;
                card.appendChild(h5);

                var p1 = document.createElement("p");
                p1.innerHTML = data[key].name;
                card.appendChild(p1);

                var p2 = document.createElement("p");
                p2.innerHTML = data[key].email;
                card.appendChild(p2);

                member.appendChild(a);
            });
        } else {
            console.log("masuk sini");
            var p = document.createElement("p");
            p.setAttribute("class", "text-center");
            p.innerHTML = "Tidak ada member yang sesuai";
            member.appendChild(p);
        }
    }
}

// Script untuk questDetail
if (window.location.href == base_url + '/Admin/questDetail') {
    document.querySelector("#delete").addEventListener("click", function () {
        if (confirm("Yakin ingin menghapusnya?")) {
            window.location.replace(
                base_url + "/Admin/deleteQuestion/" + to_id + "/" + q_number
            );
        }
    });
}

// Script untuk orgManager
if (window.location.href == base_url + '/Admin/orgManager') {
    var memberSearch = document.getElementById("member-search");
    var member = document.getElementById("org-member");


    memberSearch.addEventListener("change", function () {
        var value = this.value;
        var data = {
            regex: value
        };

        ajax("POST", base_url + "/Admin/orgMember/", data, ajaxFunc);
    });
}

// var form = document.querySelector('#q_form_change');
// document.querySelector('#q_change').addEventListener('click', function () {
//     var isSure = confirm('Yakin ingin mengubahnya?');
//     if (isSure) {
//         form.submit();
//     }
// })

// var q_change = document.querySelectorAll('.q_change');
// var qname = document.querySelectorAll('.q');
// var inputName = [
//     qname[0].name, qname[1].name, qname[2].name + qname[3].name + qname[4].name + qname[5].name + qname[6].name
// ]
// q_change.forEach(function (btn, index) {
//     btn.addEventListener('click', function () {
//         var isSure = confirm('Yakin ingin mengubahnya?');
//         if (isSure) {
//             // new FormData object
//             var formdata = new FormData();

//             // textual parameters
//             if (index == 2) {
//                 formdata.append('q_choices', 'true');
//                 for (i = index; i <= 6; i++) {
//                     formdata.append(qname[i].name, qname[i].value);
//                     console.log(qname[i].name + ' ' + qname[i].value);
//                 }
//             } else {
//                 formdata.append(qname[index].name, qname[index].value);
//                 console.log(qname[index].name + ' ' + qname[index].value);
//             }

//             // send form data in AJAX request
//             var xhr = new XMLHttpRequest();
//             let url = base_url + '/Admin/updateQuestion/' +
//                 to_id + '/' + q_number;
//             xhr.open('POST', url, true);
//             xhr.onreadystatechange = function () {
//                 if (this.status == 200) {
//                     console.log(this.responseText);
//                 }
//             }

//             xhr.send(formdata);
//         }
//     })
// });