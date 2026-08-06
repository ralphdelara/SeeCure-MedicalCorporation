import { usePage } from '@inertiajs/react';
import React from 'react';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { VitalSigns } from '@/types/vital-signs';
import type { PassFormDataProps } from './types';

interface InertiaProps {
    vitalSigns: VitalSigns[];
}

const VitalSignsForm = ({ data, setData }: PassFormDataProps) => {
    const { vitalSigns } = usePage().props as unknown as InertiaProps;

    const setVitalSignData = (
        e: React.ChangeEvent<HTMLInputElement>,
        id: number,
        fieldId: number,
    ) => {
        const vitalSignsData = { ...data.vital_signs };

        if (!vitalSignsData[id]) {
            vitalSignsData[id] = {};
        }

        vitalSignsData[id][fieldId] = e.target.value;

        setData('vital_signs', vitalSignsData);
    };

    return (
        <section role="tabpanel" className="body current">
            <div className="row">
                {vitalSigns.map((item, index) => {
                    const vitalSign = data.vital_signs[item.id];

                    return (
                        <div className="col-md-4" key={'vsigns-' + index}>
                            <div className="form-group">
                                <Label htmlFor={item.name.replace(' ', '_')} className="form-label">
                                    {item.name}
                                </Label>
                                <div>
                                    {item.fields.map((itemField, indexField) => {
                                        let vitalSignData: string | number = '';

                                        if (vitalSign && vitalSign[itemField.id]) {
                                            vitalSignData = vitalSign[itemField.id];
                                        }

                                        return (
                                            <Input
                                                type="number"
                                                min="1"
                                                key={itemField.name.replace(' ', '_') + indexField}
                                                placeholder={
                                                    itemField.name + ' (' + itemField.unit + ')'
                                                }
                                                onChange={(e) =>
                                                    setVitalSignData(e, item.id, itemField.id)
                                                }
                                                value={vitalSignData}
                                            />
                                        );
                                    })}
                                </div>
                            </div>
                        </div>
                    );
                })}
            </div>
        </section>
    );
};

export default VitalSignsForm;
