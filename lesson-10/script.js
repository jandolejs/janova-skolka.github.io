document.addEventListener( 'DOMContentLoaded', start, false );

function start() {
    var button = document.getElementById('run');
    button.addEventListener( 'click', query, false );
}

function query() {
    reset();
    var sqlInput = document.getElementById('sql');
    if(sqlInput.validity.valid === false) {
        return false;
    }
    var sql = sqlInput.value;
    asyncRequest(sql)
        .then((data) => {
            printResult(data);
        })
        .catch((status) => {
            printError("Při volání došlo k chybě: " + status);
        });
}

function printResult(data) {
    try{
        if(data.status !== true) {
            throw new Error(data.error);
        }

        printStats(data.data.rows, data.data.insertedId);
        printTable(data.data.results);
    }
    catch(e) {
        printError(e.message);
    }
}

function printTable(data) {
    if(!data || !data.length) {
        return;
    }
    var table = document.querySelector("#result table");

    // header
    var tr = document.createElement('thead');
    table.appendChild(tr);
    var tbody = document.createElement('tbody');
    table.appendChild(tbody);

    var header = document.createElement('tr');
    Object.keys(data[0]).forEach((col) => {
        var th = document.createElement('th');
        th.innerText = col;
        header.appendChild(th);
    });
    tr.appendChild(header);

    // body
    data.forEach(row => {
        var tr = document.createElement('tr');
        Object.values(row).forEach((col) => {
            var td = document.createElement('td');
            td.innerText = col;
            tr.appendChild(td);
        });
        tbody.appendChild(tr);
    });

    var result = document.getElementById("result");
    result.style.display='';
}

function printStats(rows, insertedId) {
    var messages = [];
    if(rows) {
        messages.push("Bylo načteno/ovlivněno " + rows + " záznam v tabulce.");
    }
    else if(rows === 0) {
        messages.push("Databáze nevrátila žádný záznam.");
    }

    if(insertedId !== "0") {
        messages.push("Nově vložený záznam má ID: " + insertedId + ".");
    }


    if(!!messages.length) {
        var alert = document.getElementById("message");
        alert.style.display='';
        alert.innerText = messages.join("\n");
    }
}

function printError(message) {
    var alert = document.getElementById("error");
    alert.style.display='';
    alert.innerText = message;
}

function reset() {
    document.querySelectorAll(".result").forEach((item)=>{item.style.display='none'});
    document.querySelectorAll("#result table thead, #result table tbody").forEach((item)=>{item.parentNode.removeChild(item)});
}

function asyncRequest(query) {
    return new Promise((resolve, reject) => {
        var reqBody = new FormData();
        reqBody.append("query", query);
        fetch("https://sql.jandolejs.cz/", {"method": "POST", "body": reqBody})
            .then(function(response){
                response.json().then((data)=>{
                    if(response.ok){
                        resolve(data);
                    }
                    else {
                        reject(data.error);
                    }
                });
            })
            .catch(function(error){
                reject(error);
            });
    });
}