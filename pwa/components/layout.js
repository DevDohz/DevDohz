import Header from './header';
import Footer from './footer';

export default function Layout (page) {
  const { children } = page;

  return (
    <div className="flex flex-col h-screen overflow-x-hidden">
      <div className="flex-none">
        <Header />
      </div>
      <main id="mainDivLayout" className="flex-1 overflow-y-auto">
        {children}
        <Footer />
      </main>
    </div>
  );
};
