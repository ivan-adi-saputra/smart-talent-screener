import { Sparkles, Menu } from "lucide-react";
import { Button } from "../ui/button";

export function Header() {
    return (
        <header className="sticky top-0 z-50 w-full border-b border-slate-200 bg-white/95 backdrop-blur">
            <div className="mx-auto max-w-7xl px-6 lg:px-8">
                <div className="flex h-16 items-center justify-between">
                    <div className="flex items-center gap-2">
                        <div className="rounded-lg bg-blue-600 p-2">
                            <Sparkles className="h-5 w-5 text-white" />
                        </div>
                        <span className="text-xl text-slate-900">
                            Smart Talent Screener
                        </span>
                    </div>

                    <nav className="hidden md:flex items-center gap-6">
                        <a
                            href="#"
                            className="text-sm text-slate-600 hover:text-slate-900 transition-colors"
                        >
                            Features
                        </a>
                        <a
                            href="#"
                            className="text-sm text-slate-600 hover:text-slate-900 transition-colors"
                        >
                            How It Works
                        </a>
                        <a
                            href="#"
                            className="text-sm text-slate-600 hover:text-slate-900 transition-colors"
                        >
                            Pricing
                        </a>
                        <a
                            href="#"
                            className="text-sm text-slate-600 hover:text-slate-900 transition-colors"
                        >
                            Blog
                        </a>
                    </nav>

                    <div className="flex items-center gap-4">
                        <Button
                            variant="ghost"
                            className="hidden md:inline-flex text-slate-600"
                        >
                            Sign In
                        </Button>
                        <Button className="bg-blue-600 hover:bg-blue-700 text-white">
                            Get Started
                        </Button>
                        <Button
                            variant="ghost"
                            size="icon"
                            className="md:hidden"
                        >
                            <Menu className="h-5 w-5" />
                        </Button>
                    </div>
                </div>
            </div>
        </header>
    );
}
