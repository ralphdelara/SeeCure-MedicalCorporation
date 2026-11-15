import { Head, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import UpdatePrivacyPolicy from './update-privacy-policy';
import DOMPurify from 'dompurify';

interface InertiaProps {
    privacyPolicy: {
        id: number;
        policy: string;
        insertNew: number;
    }
}

export default function PrivacyPolicy() {
    const { privacyPolicy } = usePage().props as unknown as InertiaProps;
    const { auth } = usePage().props as unknown as {
        auth: { user: { is_admin: boolean; }; };
    };

    return (
        <>
            <Head title="Privacy Policy" />
            <Breadcrumbs title="Privacy Policy">
                {auth.user.is_admin ? <UpdatePrivacyPolicy /> : <>&nbsp;</>}
            </Breadcrumbs>


            <div className="card border shadow-sm">
                <div className="card-body">
                    {privacyPolicy
                        ? <div
                            className="html-list-reset py-1 pe-3 text-dark fs-5"
                            dangerouslySetInnerHTML={{
                                __html: DOMPurify.sanitize(
                                    privacyPolicy.policy,
                                ),
                            }}>
                        </div>
                        : <center><h2>
                            <b>No Privacy Policy</b>
                            <br />Click <b>Update Privacy Policy</b> create new
                        </h2></center>
                    }
                </div>
            </div>
        </>
    );
}
