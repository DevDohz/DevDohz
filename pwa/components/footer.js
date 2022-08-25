import s from '../styles/footer.module.css'
import Image from 'next/image'
import Link from 'next/link'

export default function Footer() {
  return (   
    <footer className={s.divFooter} >
      <Image
        src="/footer-separateur vert.png"
        alt="Open Jujitsu Self Defense Logo"
        width={1620}
        height={30}
        priority={true}
      />    
      <div className="flex flex-row sm:-mt-4 -mt-2">
        {/* Logo OJSD fixe */}
        <div className="flex-none self-center ">
          <Image
            src="/footer-ojsd.png"
            alt="Open Jujitsu Self Defense Logo"
            width={147}
            height={70}
          />
        </div>

        {/* Menu simple espacé */}
        {/* <div className="hidden sm:flex sm:flex-grow space-x-4 self-center place-content-center " > */}
        <div className="flex flex-grow space-x-4 self-center place-content-center " >
          <Link href="/contact">
            <a className={s.myLink}>Contact</a>
          </Link>
          <p>-</p>
          {/* TODO mettre la bonne page */}
          <Link href="/mentionslegales"> 
            <a className={s.myLink}>Infos légales</a>
          </Link>
          <p className="hidden sm:flex">-</p>
          {/* TODO mettre la bonne page */}
          <Link href="/contact"> 
            <a className={`${s.myLink} hidden sm:flex`}>Plan du site</a>
          </Link>
        </div>

        {/* Info réccap OJ */}
        <div className="hidden md:flex sm:flex-col mr-0 text-center">
          <p className="text-xl"><span className="font-bold">Open</span> <span className="text-ojgreen">Jujitsu</span></p>
          {/* <p>contact<span className="text-ojgreen">@</span>openjujitsu<span className="text-ojgreen">.</span>fr</p> */}
          <p>51 avenue de Madran, 33600 Pessac</p>
          <p>05 56 36 94 49</p>
        </div>      
      </div>
    </footer>
  )}