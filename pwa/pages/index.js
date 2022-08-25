import Head from 'next/head';

export default function AccueilMain() {
    return (
      <div>
        <Head><title>{process.env.NEXT_PUBLIC_SITE_NAME_OJ} - BackOffice</title></Head>
        <h1 className="text-4xl sm:text-5xl text-center">
           Accueil - BackOffice Open Jujitsu
        </h1>
      </div>
    );
};
