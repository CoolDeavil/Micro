interface IParallaxElement extends HTMLInputElement {
    speed: string;
}
export default class MicroUI {
    private appHero: HTMLElement;
    private appNav: HTMLElement;
    private sideNav: HTMLElement;
    private fab: HTMLElement;
    private readonly toggle: HTMLElement;
    private formSwitch: HTMLFormElement;
    private appContent: HTMLElement;
    private languageValue: HTMLInputElement;
    public langSwitch: NodeListOf<HTMLElement>;
    private windowMediaQuery: string;
    public stickyActive: boolean;
    private windowY: number;
    private windowX: number;
    private heroHeight: number;
    public parallax: Boolean;
    public parallaxElements: IParallaxElement[];
    private readonly callParallax: any;
    private background: HTMLElement;

    constructor(parallaxElements: [], callBack:any = null) {
        this.appHero = document.querySelector(".appHero");
        this.appContent = document.querySelector(".appContent");
        this.appNav = document.querySelector(".appNavigation");
        this.sideNav = document.querySelector(".appSideNavOverlay");
        this.fab = document.querySelector(".cFab");
        this.background = this.appHero.querySelector('.backGround');
        this.langSwitch = document.querySelectorAll(".language");
        this.formSwitch = document.querySelector("#formSwitch");
        this.languageValue = document.querySelector('input[name="language"]');
        // this.parallaxElementList = parallaxElements;
        this.stickyActive = true;
        this.parallax = true;

        if (!this.checkParallaxParams(parallaxElements)){
            this.parallax = false;
            console.log("[#] " , this.parallax)
        }

        if(this.parallax){
            if(callBack){
                this.callParallax = callBack;
            }else{
                this.callParallax = this.setTranslateFactor;
            }

        }
        if(document.querySelector(".appSideNavOverlay")){
            this.toggle = document.querySelector(".js_hamburger");
        }
        this.setEventHandlers();
        this.onWindowResize()
        this.onWindowScroll()
        console.log('SkeletonUI V0.0.2')
    }
    checkParallaxParams(config: any[]){
        this.parallaxElements =  Array.prototype.slice.call(this.appHero.querySelectorAll('.parallax'), 0);
        if(this.parallaxElements.length !== config.length){
            console.log("Parallax Config is invalid...");
            return false;
        }
        config.forEach((entry:any,i)=>{
            let pe = this.parallaxElements.find((el:any)=>{
                return el.classList.contains(entry.target);
            });
            pe.speed = config[i].speed
        })
        return true;
    }
    setEventHandlers() : void {
        window.addEventListener('scroll',this.onWindowScroll.bind(this),false);
        window.addEventListener('resize',this.onWindowResize.bind(this),false);
        this.fab.onclick = (e)=>{
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });

            this.fab.classList.add('pressed');
            setTimeout(()=>{
                this.fab.classList.remove('pressed');
            }, 500);
        }
        if(this.toggle){
            this.toggle.onclick = ()=>{
                this.sideNav.classList.toggle('isShow');
                this.sideNav.querySelector('.appSideNav').classList.toggle('showNavAnim');
            };

        }
        [].forEach.call(this.langSwitch, (l:HTMLElement)=>{
            l.onclick = (e:MouseEvent)=>{
                e.preventDefault();
                this.languageValue.value = (e.target as HTMLElement).classList[1].replace(/ /g,'');
                this.formSwitch.submit();
            }
        });

        let dropdown = document.getElementsByClassName("dropdown-btn");
        let i;
        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                let dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }

    }
    onWindowScroll() : void {
        this.windowY = Math.round( window.pageYOffset
            || document.documentElement.scrollTop
            || document.body.scrollTop || 0);
        this.windowX = Math.round(window.pageXOffset);
        this.handleUIScroll(this.windowX, this.windowY);
    }
    onWindowResize() : void {
        this.windowY = Math.round(window.pageYOffset);
        this.windowX = Math.round(window.pageXOffset);
        this.windowMediaQuery = MicroUI.getCurrentMQuery();
        let viewport_width = window.innerWidth;
        // let viewport_height = window.innerHeight;
        // this.background.style.backgroundSize = `${viewport_width}px auto`;
        this.handleUIResize();
    }
    handleUIScroll(curX: number, curY: number) {
        this.heroHeight = this.appHero.offsetHeight;
        if(this.stickyActive){
            if (curY >= this.heroHeight) {
                this.appNav.classList.add('isSticky');
                this.appContent.classList.add('isSticky');
                this.fab.classList.add('isShow');
            } else {
                this.appNav.classList.remove('isSticky');
                this.appContent.classList.remove('isSticky');
                this.fab.classList.remove('isShow');
            }
        }
        if(this.parallax){
            let xScrollPosition = window.pageXOffset;
            let yScrollPosition = window.pageYOffset;
            if(!this.appNav.classList.contains("isSticky") && this.parallax === true ){
                this.parallaxElements.forEach((pe:any)=>{
                    this.callParallax(pe,this.windowX,this.windowY,yScrollPosition,pe.speed);
                })
            }
        }
    }
    setTranslateFactor(el:any,xPos:any,yPos:any,yScrollPosition:any,speed:any){
        el.style.transform = "translate3D("+(xPos)+"px, "+eval(yPos.toString()+speed)+"px, 0)"
    }
    handleUIResize() : void  {
        if(!this.stickyActive){ return }
        this.heroHeight = this.appHero.offsetHeight;
        if (this.windowMediaQuery === 'mobile' || this.windowMediaQuery === 'mobile_xs') {
            this.appNav.classList.add('isSticky');
            this.appContent.classList.add('isSticky');
        } else {
            this.handleUIScroll(this.windowX, this.windowY);

            if(this.toggle){
                this.sideNav.classList.remove('isShow');
                this.sideNav.querySelector('.appSideNav').classList.remove('showNavAnim');
            }
        }
    }
    static getCurrentMQuery() : string {
        return window.getComputedStyle(document.querySelector('body'), ':before').getPropertyValue('content').replace(/"/g, '');
    }
}