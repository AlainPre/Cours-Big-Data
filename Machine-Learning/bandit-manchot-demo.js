

const url = "http://alainpre.free.fr/cours/big-data/bandit-manchot/bandit-manchot.php?no=";
const NB_MACHINES = 100;

let gains = Array(NB_MACHINES + 1).fill(0);
let coups = Array(NB_MACHINES + 1).fill(0);
let perfs = Array(NB_MACHINES + 1).fill(0);
let bests = Array(NB_MACHINES + 1).fill(1);

var gainsTot = 0, coupsTot = 0;     // gains total et nb de coups total
var etape = 0;

function apprendre() {
//    exploration(1, 10); // Explorer toutes les machines 10 fois
//   setTimeout(function() {production(1, 10);}, 150000);  // Explorer les 10 meilleures machines
    etape++;
    if(etape < 100) {
        var noMax = NB_MACHINES - etape;
        production(1, noMax);
        setTimeout(function() {apprendre();}, 15000);
    }
}
function production(n, nb) {
    if(n <= nb) {
        jouer(bests[n]);
        setTimeout(function() {production(n + 1, nb);}, 150);
    }
}
function exploration(n, nb) {
    if(n < nb) {
        jouerToutes(1);
        setTimeout(function() {exploration(n + 1, nb);}, 15000);
    }
}
function jouerUne() {
    var no = document.querySelector('#no').value;
    jouer(no);
}

function jouerToutes(no) {
    if(no <= 100) {
        jouer(no);
        setTimeout(function() {jouerToutes(no + 1);}, 150);
    }
}
function jouer(no) {
    var box = document.querySelector('#m' + no);
    box.classList.add('encours');
    var httpRequest = new XMLHttpRequest();
    httpRequest.open('GET', url + no, true);
    httpRequest.onload = function() {
        if (httpRequest.status === 200) {
            var json = JSON.parse(httpRequest.responseText);
            gains[json.resultat.no] += json.resultat.gain;
            coups[json.resultat.no]++;
            perfs[json.resultat.no] = gains[json.resultat.no] / coups[json.resultat.no];
            box.innerHTML = '<span class="gain">Gain : ' + gains[json.resultat.no] + '</span><br/>';
            box.innerHTML+= '<span class="coup">Nb jeux : ' + coups[json.resultat.no] + '</span><br/>';
            box.innerHTML+= '<span class="perf">Performance : ' + perfs[json.resultat.no] + '</span>';
            trier();
            box.classList.remove('encours');
            gainsTot += json.resultat.gain;
            coupsTot++;

            document.querySelector('#stats-gains').innerText = 'Gain total : ' + gainsTot;
            document.querySelector('#stats-coups').innerText = 'Nb de coups : ' + coupsTot;
            document.querySelector('#stats-perfs').innerText = 'Performance : ' + gainsTot / coupsTot;

            // Colorier les meilleures mcahines:
            for(let i=1; i<=NB_MACHINES; i++) {
                var no = bests[i];
                if(i<=10) {
                    document.querySelector('#m'+no).classList.add('best');
                }
                else {
                    document.querySelector('#m'+no).classList.remove('best');
                }
            }
        }
    };
    httpRequest.send();
}
function trier() {
    // Recopier les performances des machines dans le tableau datas[]
    let datas = Array(NB_MACHINES+1);
    for(i=1; i<=NB_MACHINES; i++) {
        datas[i] = perfs[i];
    }

    // Transférer les numéros de machines dans best[] dans l'ordre de performance:
    for(n=1; n<=NB_MACHINES; n++) {
        maxData = 0;
        maxIndex = 0;
        for(i=NB_MACHINES; i>=1; i--) {                        
            if(datas[i] >= maxData) {                        
                maxData = datas[i];
                maxIndex = i;
            }                    
        }
        datas[maxIndex] = -1;
        bests[n]=maxIndex;
    }
}