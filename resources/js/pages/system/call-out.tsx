import { Head, usePage } from '@inertiajs/react';
import logo from '@/assets/images/logos/logo.png';
import { useEffect, useRef, useState } from 'react';
import {
    IconBuildingBank,
    IconFlask,
    IconHome,
    IconPrescription,
    IconReportMoney,
    IconScan,
    IconStethoscope,
} from '@tabler/icons-react';
import '@/assets/css/call-out.css';
import { echo } from '@/components/echo';
import notificationSound from '@/assets/sounds/ding-dong.mp3';
import { useSpeech } from 'react-text-to-speech';
import { system } from '@/routes';
import { Select } from '@/components/ui/select';
import ad1_1 from '@/assets/images/ads/ad1-1.svg';
import ad1_2 from '@/assets/images/ads/ad1-2.svg';
import ad1_3 from '@/assets/images/ads/ad1-3.svg';
import ad2_1 from '@/assets/images/ads/ad2-1.svg';
import ad2_2 from '@/assets/images/ads/ad2-2.svg';
import ad2_3 from '@/assets/images/ads/ad2-3.svg';
import { item } from '@/routes/billing-supplies';

export default function CallOut() {
    const { pendingCounts } = usePage().props as unknown as {
        pendingCounts: {
            Consultation: number;
            Laboratory: number;
            Radiology: number;
            Pharmacy: number;
            Billing: number;
            Cashier: number;
        };
    };
    const [speechText, setSpeechText] = useState('');
    const [maximize, setMaximize] = useState(false);
    const startButtonRef = useRef<HTMLButtonElement>(null);
    const [blinkText, setBlinkText] = useState('blink');
    const [voiceList, setVoiceList] = useState([]);
    const [selectedSpeaker, setSelectedSpeaker] = useState('');
    const [selectedSpeakerValue, setSelectedSpeakerValue] = useState('');

    const { Text, speechStatus, start, pause, stop } = useSpeech({
        text: speechText.split('|')[0],
        pitch: 1,
        rate: 0.9,
        volume: 1,
        lang: 'en-US',
        voiceURI: selectedSpeaker,
        autoPlay: false,
        highlightText: true,
        showOnlyHighlightedText: false,
        highlightMode: 'word',
        enableDirectives: false,
    });

    const [calledDepartment, setCalledDepartment] = useState({
        department: '',
        patientName: '',
    });
    const [dateString, setDateString] = useState('-');
    const [timeString, setTimeString] = useState('--:--:--');
    const [latestCalled, setLatestCalled] = useState<any>({
        Consultation: '',
        Laboratory: '',
        Radiology: '',
        Pharmacy: '',
        Billing: '',
        Cashier: '',
    });
    const [upNext, setUpNext] = useState<any>({
        Consultation: '',
        Laboratory: '',
        Radiology: '',
        Pharmacy: '',
        Billing: '',
        Cashier: '',
    });
    const [waitingPatients, setWaitingPatients] = useState<any>({
        Consultation: pendingCounts['Cashier'],
        Laboratory: pendingCounts['Laboratory'],
        Radiology: pendingCounts['Radiology'],
        Pharmacy: pendingCounts['Pharmacy'],
        Billing: pendingCounts['Billing'],
        Cashier: pendingCounts['Cashier'],
    });

    const departments = [
        {
            name: 'Consultation',
            icon: <IconStethoscope />,
            grad: 'grad-sky',
            ring: 'ring-sky',
            chip: 'chip-sky',
        },
        {
            name: 'Laboratory',
            icon: <IconFlask />,
            grad: 'grad-violet',
            ring: 'ring-violet',
            chip: 'chip-violet',
        },
        {
            name: 'Radiology',
            icon: <IconScan />,
            grad: 'grad-rose',
            ring: 'ring-rose',
            chip: 'chip-rose',
        },
        {
            name: 'Billing',
            icon: <IconBuildingBank />,
            grad: 'grad-sky',
            ring: 'ring-sky',
            chip: 'chip-sky',
        },
        {
            name: 'Pharmacy',
            icon: <IconPrescription />,
            grad: 'grad-violet',
            ring: 'ring-violet',
            chip: 'chip-violet',
        },
        {
            name: 'Cashier',
            icon: <IconReportMoney />,
            grad: 'grad-emerald',
            ring: 'ring-emerald',
            chip: 'chip-emerald',
        },
    ];

    const formatDate = () => {
        const date = new Date();
        const formattedDate = new Intl.DateTimeFormat('en-US', {
            weekday: 'long',
            month: 'long',
            day: 'numeric',
        }).format(date);

        let hours = date.getHours();
        const ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12;
        const strHours = String(hours).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        setDateString(formattedDate);
        setTimeString(`${strHours}:${minutes}:${seconds} ${ampm.toUpperCase()}`);
    };

    useEffect(() => {
        const timer = setInterval(() => {
            formatDate();
        }, 1000);
        return () => clearInterval(timer);
    }, []);

    useEffect(() => {
        if (typeof window !== 'undefined' && window.speechSynthesis) {
            const updateVoices = () => {
                setVoiceList(window.speechSynthesis.getVoices() as any);
            };

            // Get initial voices
            updateVoices();

            // Browsers load voices asynchronously, so listen for changes
            window.speechSynthesis.onvoiceschanged = updateVoices;

            return () => {
                window.speechSynthesis.onvoiceschanged = null;
            };
        }
    }, []);

    useEffect(() => {
        setSelectedSpeaker(localStorage.getItem('speaker') ?? ('' as any));
        setSelectedSpeakerValue(localStorage.getItem('speaker-value') ?? ('' as any));
    }, [localStorage]);

    const playSound = async () => {
        const audio = new Audio(notificationSound);
        try {
            await audio.play();
        } catch (e) {
            if (e instanceof Error) {
                console.error(e.message);
                console.error(e.stack);
            } else {
                console.error('An unexpected error occurred:', e);
            }
        }
    };

    useEffect(() => {
        const channel = echo.channel('call-out');

        channel.listen(
            'CallOut',
            (e: {
                patientName: string;
                department: string;
                upNext: string;
                departmentCount: string;
            }) => {
                playSound();

                setCalledDepartment({
                    patientName: e.patientName,
                    department: e.department,
                });

                setLatestCalled((prev: any) => ({
                    ...prev,
                    [e.department]: e.patientName,
                }));

                setUpNext((prev: any) => ({
                    ...prev,
                    [e.department]: e.upNext,
                }));

                setWaitingPatients((prev: any) => ({
                    ...prev,
                    [e.department]: e.departmentCount,
                }));

                // adding date ensures the call out will talk even with same patient name and department name
                setSpeechText(
                    `Patient ${e.patientName}, please proceed to ${e.department}. NOW!!!!|${new Date()}`,
                );

                setBlinkText('blink');

                setTimeout(() => {
                    setBlinkText('');
                }, 6000);
            },
        );

        return () => {
            echo.leaveChannel('call-out');
        };
    }, []);

    useEffect(() => {
        setTimeout(() => {
            if (startButtonRef.current) {
                startButtonRef.current?.click();
            }
        }, 2000);
    }, [speechText]);

    const toggleMaximize = async (isMaximize: boolean) => {
        setMaximize(isMaximize);

        try {
            if (isMaximize) {
                // Only request if not already full screen
                if (!document.fullscreenElement) {
                    await document.documentElement.requestFullscreen();
                }
            } else {
                // CRITICAL FIX: Only exit if there is an active element to exit from
                if (document.fullscreenElement) {
                    await document.exitFullscreen();
                }
            }
        } catch (error) {
            // Handle cases where the browser blocks the action
            console.error('Fullscreen toggle failed:', error);

            // Rollback state if the browser blocked the action
            setMaximize(false);
        }
    };

    const updateSpeaker = (e: any) => {
        localStorage.setItem('speaker', e.target.options[e.target.selectedIndex].text);
        localStorage.setItem('speaker-value', e.target.value);
        setSelectedSpeaker(e.target.options[e.target.selectedIndex].text);
        setSelectedSpeakerValue(e.target.value);
    };

    return (
        <div className="call-out">
            <Head title="Call Out" />
            <div className="hidden">
                <button ref={startButtonRef} onClick={start}>
                    Start
                </button>
            </div>
            <div className="screen">
                <header className="topbar-call-out">
                    <div className="brand">
                        <img className="logo" src={logo} alt="SEE CURE Medical Corporation logo" />
                        <div className="controls">
                            <button
                                className="icon-btn"
                                type="button"
                                aria-label="Home"
                                onClick={() => (window.location.href = system().url)}
                            >
                                <IconHome />
                            </button>
                            <a
                                className="icon-btn"
                                href="#sound-modal"
                                aria-label="Open voice settings"
                            >
                                <svg
                                    aria-hidden="true"
                                    width="22"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#FFFFFF"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                >
                                    <path d="M11 5 6 9H2v6h4l5 4V5z" />
                                    <path d="M15.5 8.5a5 5 0 0 1 0 7" />
                                    <path d="M19 5a10 10 0 0 1 0 14" />
                                </svg>
                            </a>
                            <button
                                className="icon-btn"
                                type="button"
                                aria-label="Full screen"
                                onClick={() => toggleMaximize(!maximize)}
                            >
                                <svg
                                    aria-hidden="true"
                                    width="22"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#FFFFFF"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                >
                                    <path d="M8 3H5a2 2 0 0 0-2 2v3" />
                                    <path d="M21 8V5a2 2 0 0 0-2-2h-3" />
                                    <path d="M3 16v3a2 2 0 0 0 2 2h3" />
                                    <path d="M16 21h3a2 2 0 0 0 2-2v-3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div className="clock">
                        {dateString} · <strong>{timeString}</strong>
                    </div>
                </header>

                <main className="content">
                    <section className="queue" aria-label="Department queues">
                        <div className="queue-head row-grid">
                            <div>DEPARTMENT</div>
                            <div>NOW SERVING · NEXT UP</div>
                            <div>WAITING</div>
                        </div>
                        {departments.map((item, index) => (
                            <article
                                className={
                                    'row-call-out row-grid' +
                                    (calledDepartment.department === item.name ? ' is-called' : '')
                                }
                                key={'department-' + index}
                            >
                                <div>
                                    <div className="dept">
                                        {item.icon} {item.name}
                                    </div>
                                    {calledDepartment.department === item.name && (
                                        <div className="callout">
                                            <svg
                                                aria-hidden="true"
                                                width="18"
                                                height="18"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="#F2CB5C"
                                                strokeWidth="2.2"
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                            >
                                                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                                                <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                                            </svg>
                                            PLEASE PROCEED
                                        </div>
                                    )}
                                </div>
                                <div>
                                    <div
                                        className={
                                            'patient' +
                                            (calledDepartment.department === item.name
                                                ? ' ' + blinkText
                                                : '')
                                        }
                                    >
                                        {latestCalled[item.name] !== ''
                                            ? latestCalled[item.name]
                                            : 'No Patients Called'}
                                    </div>
                                    <div className="next">
                                        Next up: <strong>{upNext[item.name]}</strong>
                                    </div>
                                </div>
                                <div className="waiting">{waitingPatients[item.name]} patients</div>
                            </article>
                        ))}
                    </section>

                    <aside className="ads" aria-label="Advertisements">
                        <a className="ad-tile ad-tile--a" href="#" aria-label="Advertisement 1">
                            <div className="track">
                                <img src={ad1_1} alt="Ad image 1-1" />
                                <img src={ad1_2} alt="Ad image 1-2" />
                                <img src={ad1_3} alt="Ad image 1-3" />
                                <img src={ad1_1} alt="" aria-hidden="true" />
                            </div>
                        </a>
                        <a className="ad-tile ad-tile--b" href="#" aria-label="Advertisement 2">
                            <div className="track">
                                <img src={ad2_1} alt="Ad image 2-1" />
                                <img src={ad2_2} alt="Ad image 2-2" />
                                <img src={ad2_3} alt="Ad image 2-3" />
                                <img src={ad2_1} alt="" aria-hidden="true" />
                            </div>
                        </a>
                    </aside>
                </main>
            </div>

            <div
                className="modal"
                id="sound-modal"
                role="dialog"
                aria-modal="true"
                aria-labelledby="sound-title"
            >
                <a className="modal-backdrop" href="#" aria-label="Close"></a>
                <div className="modal-card">
                    <div className="modal-head">
                        <h2 id="sound-title">Update Voice</h2>
                        <a className="modal-x" href="#" aria-label="Close">
                            <svg
                                aria-hidden="true"
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2.2"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            >
                                <path d="M18 6 6 18" />
                                <path d="m6 6 12 12" />
                            </svg>
                        </a>
                    </div>
                    <div className="field">
                        <label htmlFor="voice">Voice</label>
                        <Select
                            onChange={(e) => updateSpeaker(e)}
                            value={selectedSpeakerValue}
                            options={voiceList}
                            required={true}
                        />
                    </div>
                    <a className="btn" href="#">
                        Done
                    </a>
                </div>
            </div>
        </div>
    );
}
