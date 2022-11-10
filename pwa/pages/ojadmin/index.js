import s from '../styles/news.module.css';
import OJLayout from '../components/layout';
import Head from 'next/head';

export default function News() {
    return (
      <OJLayout>
          <Head><title>{process.env.NEXT_PUBLIC_SITE_NAME_OJ} - News</title></Head>
        <h1 className={s.title}>
           Accueil OJ Admin
        </h1>
      </OJLayout>
    );
};
