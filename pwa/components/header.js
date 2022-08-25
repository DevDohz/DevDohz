import s from '../styles/header.module.css'
import Head from 'next/head'
import Link from 'next/link'
import Menumain from './menumain'
import Image from 'next/image'

export default function Header() {
  return (
    <div className={s.divHeader}>
      <Head>
          <title>{process.env.NEXT_PUBLIC_SITE_NAME_OJ}</title>
          <meta property="og:title" content={process.env.NEXT_PUBLIC_SITE_NAME_OJ} key="title" />
          <meta name="author" content="Dohz" />
          <meta name="description" content="Site officiel de Open Jujitsu. Du Jujitsu, de la self défense, des news, des photos, des infos..."></meta>
          <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
          <link rel="icon" href="/favicon.ico" type="image/x-icon" />
      </Head>
      
      <div className="flex flex-col md:flex-row">
        {/* Logo Open Jujitsu */}
        {/* EVOL? : La zone et le logo doivent se réduire quand scroll vers le bas : */}
        {/* <div className="flex-shrink w-fit z-20 max-h-20 md:max-h-36"> */}
        <div className="flex-none z-20 relative w-[164px] md:w-[295px] h-20 md:h-36">
          <Link href="/" className="max-h-20 md:max-h-36">
            <a>
              {/* <img src="/header-LogoTexte-losange-blanc.png" alt="Open Jujitsu Logo" className="h-20 md:h-36" /> w:164 h:80 / w:295 h:144 */}
              <Image src="/header-LogoTexte-losange-blanc.png" alt="Open Jujitsu Logo" layout="fill" objectFit="contain" priority/> 
            </a>
          </Link>
        </div>
        
        {/* Phrase d'accroche + Menu */}
        <div className="flex flex-col flex-grow -mt-[3.75rem] md:mt-0 pt-2 z-10">
          <div className="hidden md:my-auto md:self-start md:flex font-bold bg-ojwhite bg-opacity-70 rounded-r-md" >
            <p>Du Jujitsu Self-Défense et tellement plus...</p>
            {process.env.NEXT_PUBLIC_SITE_NAME_OJ}
          </div>

          {/* intégration du Menu (+ menu burger en mode mobile) */}
          <div >
          {/*   <Menumain />   */}     
          </div>
        </div>

      </div>

      {/* Truc de recherche de tout (texte, images, vidéo, lexique etc...) => Future évol */}
      {/* Zone de Connexion + une fois identifié. => Future évol */}
    </div>
  )}