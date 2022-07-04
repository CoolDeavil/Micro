
// declare global {
//     interface Window {
//     }
// }


import MicroUI from "./Classes/microUI";

String.prototype.replaceAll = function(search:any, replacement:any) {
    let target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};
declare global {
    interface Array<T> {
        unique(o: T): Array<T>;
    }
}
Array.prototype.unique = function() {
    return this.filter(function (value:any, index:any, self:any) {
        return self.indexOf(value) === index;
    });
};


export function main(){
 console.log('Assets Bundled by Webpack!... And ready to go!');

    let elements: any = [
        // {target: 'backGround', speed: '*(-1.5)'},
        {target: 'microLogo', speed: '*(0.5)'}
    ];
    new MicroUI(elements);

}

if (document.readyState === 'complete') {
    main()
} else {
    document.addEventListener('DOMContentLoaded', main);
}