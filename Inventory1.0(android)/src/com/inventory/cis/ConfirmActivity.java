package com.inventory.cis;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

public class ConfirmActivity extends Activity implements OnClickListener {

    EditText et_ip, et_port;
    Button btn_save;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.confirm);

        et_ip = (EditText) findViewById(R.id.et_ip);
        et_port = (EditText) findViewById(R.id.et_port);
        btn_save = (Button) findViewById(R.id.btn_save);
        btn_save.setOnClickListener(this);

        setPrevious();
    }

    public void setPrevious() {
        SharedPreferences prefs = getSharedPreferences(SessionManager.PREF_NAME, SessionManager.PRIVATE_MODE);

        String ip = prefs.getString(StaticData.ip_key, "");//"No name defined" is the default value.
        String port = prefs.getString(StaticData.port_key, "");

        et_ip.setText(ip);
        et_port.setText(port);
    }
    @Override
    public void onClick(View view) {
        confirmServer();
        Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        startActivity(intent);
        finish();

    }

    private void confirmServer() {
        SharedPreferences.Editor editor = getSharedPreferences(SessionManager.PREF_NAME, SessionManager.PRIVATE_MODE).edit();
        String port = et_port.getText().toString();
        String ip = et_ip.getText().toString();
        editor.putString(StaticData.port_key, port);
        editor.putString(StaticData.ip_key, ip);
        editor.commit();
    }
}
