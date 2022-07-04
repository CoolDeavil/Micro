
export function main(){
 console.log('Assets Bundled by Webpack!... And ready to go![TEST]');

}

if (document.readyState === 'complete') {
    main()
} else {
    document.addEventListener('DOMContentLoaded', main);
}